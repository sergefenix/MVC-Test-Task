<?php

namespace App\Controllers;

class FindWayForWord extends Controller
{
    private $words_passed;
    private $dictionary;
    private $first_word;
    private $result_arr;
    private $last_word;

    public function __construct()
    {
        parent::__construct();

        $this->first_word = '';
        $this->last_word = '';
        $this->words_passed = [];
        $this->result_arr = [];

        $dictionary = file_get_contents('./config/dictionary.php');
        $this->dictionary = explode("\n", $dictionary);
    }

    public function index()
    {
        $data = ['cook' => $this->cook];
        $this->view->render('metagram.html.twig', $data);
    }

    public function create()
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
     * @return bool
     */
    public function LoadWords($first, $last): bool
    {
        $this->first_word = $first;
        $this->last_word = $last;
        $this->result_arr[] = $first;

        return true;
    }

    /**
     * @param $word
     * @return array
     */
    public function FindChildren($word)
    {
        $parent = preg_split('//u', $word, NULL, PREG_SPLIT_NO_EMPTY);
        $array_of_children = [];
        foreach ($this->dictionary as $item) {
            $j = 0;
            if ($item == $this->first_word) {
                continue;
            }
            $child = preg_split('//u', $item, NULL, PREG_SPLIT_NO_EMPTY);

            //Ищет слова у которых совпадает 3 буквы.
            for ($i = 0; $i <= 3; $i++) {
                if ($parent[$i] === $child[$i]) {
                    ++$j;
                }
            }
            if ($j == 3) {
                $array_of_children[] = $item;
            }
        }
        if ($array_of_children) {
            return $array_of_children;
        }
    }

    /**
     * @param array $array_of_childrens
     * @return array
     */
    public function FindNewChildren($array_of_childrens)
    {
        $this->words_passed = array_unique(array_merge($this->words_passed, $array_of_childrens));
        $good_children = [];
        $new_children = [];
        foreach ($array_of_childrens as $word) {
            $words = $this->FindChildren($word);

            if ($words === NULL) {
                continue;
            }

            $new_children[] = $words;
            $this->result_arr[] = array_merge(str_split($word, 8), $words);
        }

        $j = count($new_children);
        $new_arr = [];

        for ($i = 1; $i < $j; $i++) {
            $arr = array_merge($new_children[$i - 1], $new_children[$i]);
            $new_arr = array_merge($arr, $new_arr);
        }

        $new_arr = array_unique($new_arr, SORT_STRING);
        $i = 0;

        foreach ($new_arr as $item) {
            foreach ($this->words_passed as $passed) {
                if ($item == $passed) {
                    $i = 1;
                }
            }

            if ($i != 1) {
                $good_children[] = $item;
            }

            $i = 0;
        }

        return array_unique($good_children, SORT_STRING);
    }

    /**
     * @return array
     */
    public function PrintWay()
    {
        $way = [];
        $count = 0;
        $way[] = $this->last_word;

        for ($i = count($this->result_arr) - 1; $i > 0; $i--) {
            $minarr = $this->result_arr[$i];

            foreach ($minarr as $val) {
                if ($val == $way[$count]) {
                    $way[] = $minarr[0];
                    $count++;
                }
            }
        }

        return $way;
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
            if ($k = array_search($this->last_word, $step_two)) {

                $finish_way = $this->PrintWay();
                $finish_way[] = $this->first_word;
                $finish_way = array_reverse($finish_way);

                return (implode('->', $finish_way));
            }

            $step_two = $this->FindNewChildren($step_two);
            $i++;
        }

        if (in_array($this->last_word, $step_one)) {

            return (implode('->', [$this->first_word, $this->last_word]));
        }

        return 'Что-то пошло не так.';
    }
}
