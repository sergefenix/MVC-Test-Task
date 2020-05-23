<?php

namespace App\Controllers;

use Components\Request;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{

    /**
     * Redirect on home page
     */
    public function home()
    {
        $tasks = new Task();
        $paginator = new Task();
        $body = $this->request->getBody();
        $paginator = $paginator->page_paginator();

        if (isset($body['val'], $body['order'])) {
            $val = $body['val'];
            $order = $body['order'];
            $paginator['val'] = $val;
            $paginator['order'] = $order;
            $tasks = $tasks->select()->orderBy($val, $order)->paginate()->fetchAll();
        } else {
            $tasks = $tasks->select()->paginate()->fetchAll();
        }

        $data = ['tasks' => $tasks, 'cook' => ['user' => $this->cook, 'admin' => $this->is_admin], 'paginator' => $paginator];
        $this->view->render('tasks.html.twig', $data);

    }

    /**
     * @return bool
     * Create task method
     * @throws Exception
     */
    public function create()
    {

        $input_file = $_FILES['InputFile'];
        $rand = random_int(1000, 10000);
        $input_file['name'] = "{$rand}{$input_file['name']}";

        $name_file = $this->resize($input_file);
        $body = $this->request->getBody();
        $body['img'] = $name_file;

        $task = new Task($body);
        $result = $task->save();

        if ($result) {
            header('Location: ' . '/TaskManager/');
        } else {
            return false;
        }
    }

    /**
     * Redirect on create task form
     */
    public function create_form()
    {
        $data = ['cook' => $this->cook];

        $this->view->render('create_task.html.twig', $data);
    }

    /**
     *  Method for delete task
     */
    public function delete_tasks()
    {
        if ($this->cook) {
            $id = $this->request->getBody()['id'];

            $task = new Task();
            $val = $task->getOne($id);

            $task->delete_img($val[0]['img']);
            $task->delete($id);

            header('Location: ' . '/TaskManager/');
        } else {
            echo 'This user does not have the necessary privileges';
            die();
        }
    }

    /**
     *  Method for update task status
     */
    public function update_tasks()
    {

        if ($this->cook) {

            $task = new Task();
            $task->update_status($this->request->getBody());

            header('Location: ' . '/TaskManager/');
        } else {
            echo 'This user does not have the necessary privileges';
            die();
        }

    }

    public function update_task_form()
    {
        $id = $this->request->getBody()['id'];
        $task = new Task();
        $task = $task->getOne($id);

        $data = ['cook' => $this->cook, 'task' => $task[0]];

        $this->view->render('update_task.html.twig', $data);
    }

    /**
     * @param $file
     * @param int $type
     * @param int $quality
     * @return bool
     */
    public function resize($file, $type = 1, $quality = 90)
    {
        $tmp_path = 'public/downloads/';

        $max_thumb_size = 320;
        $max_hight = 240;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] === 'image/jpeg') {
            $source = imagecreatefromjpeg($file['tmp_name']);
        } elseif ($file['type'] === 'image/png') {
            $source = imagecreatefrompng($file['tmp_name']);
        } elseif ($file['type'] === 'image/gif') {
            $source = imagecreatefromgif($file['tmp_name']);
        } else {
            return false;
        }

        $src = $source;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($src);
        $h_src = imagesy($src);
        $w = $max_thumb_size;

        // Если ширина больше заданной
        if ($w_src > $w) {
            // Вычисление пропорций
            $ratio = $w_src / $w;
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            if ($h_dest > $max_hight) {
                $h_dest = $max_hight;
            }

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $tmp_path . $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($src);

            return $file['name'];
        }

        // Вывод картинки и очистка памяти
        imagejpeg($src, $tmp_path . $file['name'], $quality);
        imagedestroy($src);

        return $file['name'];
    }
}