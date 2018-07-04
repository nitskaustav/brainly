<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenDate;
use Cake\Database\Type;

Type::build('date')->setLocaleFormat('yyyy-MM-dd');

/**
 * Medicines Controller
 *
 * @property \App\Model\Table\Medicines Table $Medicines
 */
class MedicinesController extends AppController {

    public $paginate = ['limit' => 24, 'order' => ['Medicines.title' => 'ASC']];

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['search']);
        $this->loadComponent('Paginator');
    }

    // Keyword Serch in Frontend
    public function search(){
        $this->viewBuilder()->layout('default');
        $this->loadModel('Treatments');
        $this->loadModel('Medicines');
        $this->loadModel('Newses');
        
        
        $session = $this->request->session();


        if (!empty($this->request->data) || !empty($session->read('data'))) {
            
            if (!empty($this->request->data)) {
                $session->write('data', $this->request->data['searchhead']);
            } else {
                $this->request->data['searchhead'] = $session->read('data');
            }            
            
            
            
            $sData = $this->request->data['searchhead'];
            
            $treatment = $this->Treatments->find() // Searching By Treatment
                    ->select(['id','name','slug','sort_descriptiion','image','is_active'])
                    ->where([ 'slug LIKE' => '%' . $sData . '%'])  
                    ->orWhere([ 'name LIKE' => '%' . $sData . '%'])
                    ->orWhere([ 'sort_descriptiion LIKE' => '%' . $sData . '%'])
                    ->orWhere([ 'description LIKE' => '%' . $sData . '%'])
                    ->all(); 

            $medicine = $this->Medicines->find() //Search By Medicines
                    ->select(['id','title','slug','note','image','is_active'])
                    ->where([ 'slug LIKE' => '%' . $sData . '%'])  
                    ->orWhere([ 'title LIKE' => '%' . $sData . '%'])
                    ->orWhere([ 'description LIKE' => '%' . $sData . '%'])
                    ->all(); 

            $news = $this->Newses->find() //Search Newses
                    ->select(['id','title','slug','sortdetail','img','is_active'])
                    ->where([ 'slug LIKE' => '%' . $sData . '%'])  
                    ->orWhere([ 'title LIKE' => '%' . $sData . '%'])
                    ->orWhere([ 'sortdetail LIKE' => '%' . $sData . '%'])
                    ->orWhere([ 'detail LIKE' => '%' . $sData . '%'])
                    ->all(); 

            $sl = 1; $finalArray = array();
            
            foreach ($treatment as $tr){
                if($tr->is_active == 1){
                    $finalArray[$sl]['id'] = $tr->id;
                    $finalArray[$sl]['name'] = $tr->name;
                    $finalArray[$sl]['slug'] = $tr->slug;
                    $finalArray[$sl]['desc'] = $tr->sort_descriptiion;
                    $finalArray[$sl]['img'] = $tr->image;
                    $finalArray[$sl]['type'] = 'treatment';
                    $finalArray[$sl]['folder'] = 'treatment_img';
                    $sl ++;
                }
            }
            
            foreach ($medicine as $medc){
                if($medc->is_active == 1){
                    $finalArray[$sl]['id'] = $medc->id;
                    $finalArray[$sl]['name'] = $medc->title;
                    $finalArray[$sl]['slug'] = $medc->slug;
                    $finalArray[$sl]['desc'] = $medc->note;
                    $finalArray[$sl]['img'] = $medc->image;
                    $finalArray[$sl]['type'] = 'medicine';
                    $finalArray[$sl]['folder'] = 'medicine_img';
                    $sl ++;
                }
            }            
            
            foreach ($news as $ne){
                if($ne->is_active == 1){
                    $finalArray[$sl]['id'] = $ne->id;
                    $finalArray[$sl]['name'] = $ne->title;
                    $finalArray[$sl]['slug'] = $ne->slug;
                    $finalArray[$sl]['desc'] = $ne->sortdetail;
                    $finalArray[$sl]['img'] = $ne->img;
                    $finalArray[$sl]['type'] = 'news';
                    $finalArray[$sl]['folder'] = 'news_img';
                    $sl ++;
                }
            }            
            //pr($finalArray); exit;
            $searcData = $this->request->data['searchhead'];
            /*
            $query = $this->Medicines->find()->contain(['Treatment']);
            if ($this->request->data['searchhead']) {

                $searchhead = $this->request->data['searchhead'];
                $query->where(['title LIKE' => '%' . $searchhead . '%']);
            } else {
                return $this->redirect('/');
            } 
            
            $this->set('medicines', $this->paginate($query));
            */
            //pr($searcData); pr($finalArray); exit;
            $this->set(compact('searcData','finalArray'));
            //$this->set('_serialize', ['medicines']);
        } else {
            return $this->redirect('/');
        }
    }

}
