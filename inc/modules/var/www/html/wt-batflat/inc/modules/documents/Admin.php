<?php

namespace Inc\Modules\Documents;

use Inc\Core\AdminModule;

class Admin extends AdminModule
{

    public function navigation()
    {
        return [
            'Zarządzaj' => 'index',
            'Dodaj' => 'add',
        ];
    }

    public function getIndex()
    {
        $assign = [];
        $rows = $this->core->db('documents')->toArray();
        if (count($rows)) {
            foreach ($rows as $row) {
                $row['editURL'] = url([ADMIN, 'documents',  'edit', $row['id']]);
                $row['delURL']  = url([ADMIN, 'documents', 'delete', $row['id']]);
                $assign[] = $row;
            }
        }
        return $this->draw('index.html', ['rows' => $assign]);
    }

    public function getEdit($id){

        $assign = [];
        $rows = $this->core->db('documents')->where('id', '=', $id)->toArray();
        if (count($rows)) {
            foreach ($rows as $row) {
                $assign[] = $row;
            }
        }

        $assign2 = [];
        $rows2 = $this->core->db('documents')->select('id')->select('title')->where('did', '=', 0)->toArray();
        if (count($rows2)) {
            foreach ($rows2 as $row2) {
                $assign2[] = $row2;
            }
        }

        return $this->draw('edit.html', ['rows' => $assign,'did' => $assign2]);
    }

    public function getAdd(){

        $assign = [];
        $rows = $this->core->db('documents')->select('id')->select('title')->where('did', '=', 0)->toArray();
        if (count($rows)) {
            foreach ($rows as $row) {
                $assign[] = $row;
            }
        }

        return $this->draw('add.html', ['rows' => $assign]);
    }

    public function PostSaveDoc(){

        
        if ($this->db('documents')->save(['title' => $_POST['title'], 'desc' => $_POST['desc'], 'publisher' => $_POST['publisher'], 'published' => $_POST['published'], 'status' => $_POST['status'], 'file' => $_FILES['file']['name'], 'did' => $_POST['did']])) {
            $this->notify('success', 'Dane zapisano pomyślnie');
        }
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if (file_exists(BASE_DIR.'/uploads/documents/'.$_FILES['file']['name'])){
                $this->notify('failure', 'Plik już istnieje');
            } else{
            move_uploaded_file($_FILES['file']['tmp_name'],BASE_DIR.'/uploads/documents/'.$_FILES['file']['name']);
            $this->notify('success', 'Plik wgrany pomyślnie');}
        } else {
            $this->notify('failure', 'Błąd wgrywania pliku');
        }
        redirect(url([ADMIN, 'documents', 'index']));
    }

    public function GetDelete($id){
        $this->core->db('documents')->delete($id);
        redirect(url([ADMIN, 'documents', 'index']));
    }

    public function PostUpdateDoc($id){
        $this->core->db('documents')->where('id', $id)->update(['title' => $_POST['title'], 'desc' => $_POST['desc'], 'publisher' => $_POST['publisher'], 'published' => $_POST['published'], 'status' => $_POST['status'], 'file' => $_FILES['file']['name'], 'did' => $_POST['did']]);
        $this->notify('success', 'Dane zapisano pomyślnie');
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if (file_exists(BASE_DIR.'/uploads/documents/'.$_FILES['file']['name'])){
                $this->notify('failure', 'Plik już istnieje');
            } else{
            move_uploaded_file($_FILES['file']['tmp_name'],BASE_DIR.'/uploads/documents/'.$_FILES['file']['name']);
            $this->notify('success', 'Plik wgrany pomyślnie');}
        } else {
            $this->notify('failure', 'Błąd wgrywania pliku');
        }
        redirect(url([ADMIN, 'documents', 'index']));
    }
}
