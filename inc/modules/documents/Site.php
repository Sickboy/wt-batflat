<?php

namespace Inc\Modules\Documents;

use Inc\Core\SiteModule;

class Site extends SiteModule
{

    public function init()
        {
            //$this->_foo();
        }

    public function routes()
        {
            $this->route('dokumenty', 'getAll');
            $this->route('dokumenty/(:int)', function($doc) {
                $this->getOne($doc);
            });
            $this->route('uchwaly', 'getAll');
            $this->route('uchwaly/(:int)', function($doc) {
                $this->getOne($doc);
            });
        }

    private function _foo()
        {           
            
        }

    public function getAll()
        {       
            $cont = '';
            $rows = $this->core->db('documents')->where('did', '==', 0)->toArray();
            if (count($rows)) {
                foreach ($rows as $row) {
                    $doc = '';
                    $rows2 = $this->core->db('documents')->select('id')->select('title')->where('did', '==', $row['id'])->asc('published')->toArray();
                    if (count($rows2)) {
                        foreach ($rows2 as $row2) {
                            $doc = $doc.'<a href=./dokumenty/'.$row2['id'].'>'.$row2['title'].'</a><br>';
                        }
                    }
                    $cont = $cont.'<a  data-toggle="collapse" href="#collapse'.$row['id'].'" role="button" ><p><font color="black"><i class="fa fa-file-text"></i>&nbsp<u>'.$row['title'].'</u></a>&nbsp</font><a href="dokumenty/'.$row['id'].'"><i class="fa fa-share"></i></a></p>';
                    //$cont = $cont.'<div class="col-lg-3"><p align="right">Tekst<br>Data uchwalenia<br>Organ uchwalający<br>Status<br>Dokumenty powiązane<br></p>';
                    //$cont = $cont.'</div><div class="col-lg-9"><a href="/uploads/documents/'.$row['file'].'" target="_blank">'.$row['file'].'</a><br>'.$row['published'].'<br>'.$row['publisher'].'<br>'.$row['status'].'<br>'.$doc.'<br></div>';
                    //$cont = $cont.'<div class="col-lg-12"><hr></div>';

                    $cont = $cont.'<div class="collapse" id="collapse'.$row['id'].'"><div class="card card-body"><table><tr><td align="right" width="30%" height="15">Tekst</td><td height="15"><a href="/uploads/documents/'.$row['file'].'" target="_blank">'.$row['file'].'</a></td></tr>
                    <tr><td align="right" width="30%">Data uchwalenia</td><td>'.$row['published'].'</td></tr><tr><td align="right" width="30%">Organ uchwalający</td><td>'.$row['publisher'].'</td></tr><tr><td align="right" width="30%">Status</td><td>'.$row['status'].'</td></tr><tr><td align="right" width="30%">Dokumenty powiązane</td><td>'.$doc.'</td></tr></table></div></div>';
                }
            }
            
            $this->setTemplate("strona.html");
            $this->tpl->set('page', ['title' => 'Dokumenty', 'content' => $cont, 'logon_only' => 1]);

        }

    public function getOne($doc)
        {       
            $cont = '';
            $rows = $this->core->db('documents')->where('id', '==', $doc)->toArray();
            if (count($rows)) {
                foreach ($rows as $row) {
                    $doc = '';
                    $rows2 = $this->core->db('documents')->select('id')->select('title')->where('did', '==', $row['id'])->toArray();
                    if (count($rows2)) {
                        foreach ($rows2 as $row2) {
                            $doc = $doc.'<a href=./dokumenty/'.$row2['id'].'>'.$row2['title'].'</a><br>';
                        }
                    }
                    $cont = $cont.'<div class="col-lg-12"><i class="fa fa-file-text"></i>&nbsp<u>'.$row['title'].'</u></div>';
                    //$cont = $cont.'<div class="col-lg-3"><p align="right">Opis<br>Tekst<br>Data uchwalenia<br>Organ uchwalający<br>Status<br>Dokumenty powiązane<br></p>';
                    //$cont = $cont.'</div><div class="col-lg-9">'.$row['desc'].'<br>'.$row['file'].'<br>'.$row['published'].'<br>'.$row['publisher'].'<br>'.$row['status'].'<br>'.$doc.'<br></div>';
                    
                    $cont = $cont.'<table><tr><td align="right" width="30%">Opis</td><td>'.$row['desc'].'</td></tr><tr><td align="right" width="30%">Tekst</td><td height="15"><a href="/uploads/documents/'.$row['file'].'" target="_blank">'.$row['file'].'</a></td></tr>
                    <tr><td align="right" width="30%">Data uchwalenia</td><td>'.$row['published'].'</td></tr><tr><td align="right" width="30%">Organ uchwalający</td><td>'.$row['publisher'].'</td></tr><tr><td align="right" width="30%">Status</td><td>'.$row['status'].'</td></tr><tr><td align="right" width="30%">Dokumenty powiązane</td><td>'.$doc.'</td></tr></table>';
                }
            }

            $this->setTemplate("strona.html");
            $this->tpl->set('page', ['title' => 'Dokumenty', 'content' => $cont, 'logon_only' => 1]);

        }
}
