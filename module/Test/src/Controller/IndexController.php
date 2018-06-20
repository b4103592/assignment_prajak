<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Test\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Cache\StorageFactory;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {       
        //Cal set_cache function
        $cache = $this->set_cache();        
        $key_1    = 'answer_1';
        $key_2    = 'answer_2';
        $key_3    = 'answer_3';
        $answer_1 = $cache->getItem($key_1);
        $answer_2 = $cache->getItem($key_2);
        $answer_3 = $cache->getItem($key_3);
        
//        $answer_1 = $answer_2 = $answer_3 = false;
        
        $set_cache = true;
        if(!$answer_1){
            $answer_1 = $this->test_1();
            $set_cache = false;
        }
        if(!$answer_2){
            $answer_2 = $this->test_2();
        } 
        if(!$answer_3){
            $answer_3 = $this->test_3();
        }     
        
        
        $view = new ViewModel(array(
            'answer_1' => $answer_1,
            'answer_2' => $answer_2,
            'answer_3' => $answer_3,
            'set_cache'=> $set_cache 
        ));
        $view->setTemplate('test/index/index');
        return $view;
    }
    
    public function set_cache()
    {
        //Setting cache
        $cache = \Zend\Cache\StorageFactory::factory(
                    array(
                            'adapter' => array(
                            'name' => 'filesystem'
                        ),
                        'plugins' => array(
                                'exception_handler' => array(
                                'throw_exceptions' => false
                            ),
                        )
                    )
                );  
        return $cache;        
    }    
    
    public function test_1()
    {
        //3, 5, 9, 15, X  - Please create new function for finding X value
        //3  = 3+(2*0)
        //5  = 3+(2*1)
        //9  = 5+(2*2)
        //15 = 9+(2*3)
        //23 = 15+(2*4) ***Answer X = 23        
        $val = 3;
        for ($i=0; $i<=5; $i++){
            $test_1_result[] = $val; 
            $val=$val+(2*$i);
        }        
        
        //Cal set_cache function
        $cache = $this->set_cache();        
        $key   = 'answer_1';
        
        //Create cache answer_1
        $cache->setItem($key, $val);      
        
        return $test_1_result;
    }  
    
    public function test_2()
    {
        //(Y + 24)+(10 × 2) = 99  - Please create new function for finding Y value
        //(Y + 24)+20 = 99
        //Y + 24 = 99-20
        //Y + 24 = 79
        //Y = 79-24
        //Y = 55 ***Answer Y = 55        
        $y = 99-(10*2)-24;  
        
        //Cal set_cache function
        $cache = $this->set_cache();        
        $key    = 'answer_2';
        
        //Create cache answer_2
        $cache->setItem($key, $y);  
        
        return $y;        
    }   
    
    public function test_3()
    {
        // If 1 = 5 , 2 = 25 , 3 = 325 , 4 = 4325 Then 5 = X - Please create new function for finding X value
        // 1 = 5
        // 2 = 25
        // 3 = 325
        // 4 = 4325
        // 5 = 54325 ***Answer X = 54325        
        $val = 5;
        for ($i=2; $i<=5; $i++){  
            $val=$i.$val;
            $test_3_result[] = $val;
            
        }         
        
        //Cal set_cache function
        $cache = $this->set_cache();        
        $key   = 'answer_3';
        
        //Create cache answer_3
        $cache->setItem($key, $val);           
        
        return $test_3_result;        
    }     
    
}
