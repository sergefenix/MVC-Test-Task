<?php

namespace App\Controllers;

class MetagramController extends Controller
{
    private $words_passed;

    private $first_word;

    private $result_arr;

    private $dictionary;

    private $last_word;

    public function __construct()
    {
        parent::__construct();

        $this->last_word = '';
        $this->first_word = '';

        $this->result_arr = [];
        $this->words_passed = [];

        $dictionary = file_get_contents('./config/dictionary.php');
        $this->dictionary = explode("\n", $dictionary);
    }

    public function index(): void
    {
        $data = ['cook' => ['user' => $this->cook, 'admin' => $this->is_admin]];
        $this->view->render('metagram.html.twig', $data);
    }

    public function create(): void
    {
        $first_word = trim(strip_tags($_POST['first_word']));
        $second_word = trim(strip_tags($_POST['second_word']));

        $this->LoadWords($first_word, $second_word);

        $data = ['cook' => $this->cook, 'result' => $this->result()];
        $this->view->render('metagram.html.twig', $data);
    }

    /**
     * @param $first
     * @param $last
     *
     * @return void
     */
    public function loadWords($first, $last): void
    {
        $this->first_word = $first;
        $this->last_word = $last;
        $this->result_arr = [];
        $this->result_arr[] = $first;
    }

    /**
     * @param $word
     *
     * @return array
     */
    public function findChildren($word): array
    {
        $parent = preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY);
        $array_of_children = [];

        foreach ($this->dictionary as $item) {
            $j = 0;
            $child = preg_split('//u', $item, null, PREG_SPLIT_NO_EMPTY);

            for ($i = 0; $i <= 3; $i++) {
                if ($parent[$i] === $child[$i]) {
                    ++$j;
                }
            }

            if ($j === 3) {
                $array_of_children[] = $item;
            }
        }

        if ($array_of_children) {
            return $array_of_children;
        }

        return [];
    }

    /**
     * @param array $array_of_childes
     *
     * @return array
     */
    public function findNewChildren($array_of_childes): array
    {
        $this->words_passed = array_unique(array_merge($this->words_passed, $array_of_childes));
        $good_children = [];
        $new_children = [];

        foreach ($array_of_childes as $word) {
            $words = $this->FindChildren($word);

            if (!$words) {
                continue;
            }

            $new_children[] = $words;
            $this->result_arr[] = array_merge(str_split($word, 8), $words);
        }

        $j = count($new_children);
        $new_arr = [];

        for ($i = 1; $i < $j; $i++) {
            $new_arr = array_unique(array_merge($new_children[$i - 1], $new_children[$i], $new_arr));
        }

        foreach ($new_arr as $item) {
            foreach ($this->words_passed as $passed) {
                if ($item === $passed) {
                    $j = 1;
                }
            }

            if ($j !== 1) {
                $good_children[] = $item;
            }

            $j = 0;
        }

        return array_unique($good_children, SORT_STRING);
    }

    /**
     * @return array
     */
    public function printWay(): array
    {
        $way = [];
        $count = 0;
        $way[] = $this->last_word;

        for ($i = count($this->result_arr) - 1; $i > 0; $i--) {
            $min_arr = $this->result_arr[$i];

            foreach ($min_arr as $val) {
                if ($val === $way[$count]) {
                    $way[] = $min_arr[0];
                    $count++;
                }
            }
        }

        $way[] = $this->first_word;
        return $this->deleteExtraWords(array_reverse($way));
    }

    /**
     * @param array $way
     *
     * @return array
     */
    public function deleteExtraWords(array $way): array
    {
        $count = count($way) - 2;
        $result = $way;

        foreach ($way as $key => $word) {
            $j = 0;
            if ($key != $count) {
                $first = preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY);
                $second = preg_split('//u', $way[$key + 2], null, PREG_SPLIT_NO_EMPTY);

                for ($i = 0; $i <= 3; $i++) {
                    if ($first[$i] === $second[$i]) {
                        ++$j;
                    }
                }

                if ($j === 3) {
                    unset($result[$key + 1]);
                }
            } else {
                return $result;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function result(): string
    {
        if ($this->first_word === $this->last_word) {
            return 'Слова одинаковы';
        }

        $step_one = $this->FindChildren($this->first_word);
        $step_two = $this->FindNewChildren($step_one);

        for ($i = 0; $i < 100;) {
            if (in_array($this->last_word, $step_two, true)) {
                return (implode('->', $this->PrintWay()));
            }

            if ($step_two = $this->FindNewChildren($step_two)) {
                $i++;
            } else {
                break;
            }
        }

        if (in_array($this->last_word, $step_one, true)) {
            return (implode('->', [$this->first_word, $this->last_word]));
        }

        return 'Что-то пошло не так.';
    }
}
