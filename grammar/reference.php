<?php
/**
 * 测试php引用.
 * User: walkskyer
 * Date: 14-4-15
 * Time: 上午11:22
 */

class temp_a{
    private $_a;
    public $b;
    public function &get_a(){
        $this->_a='abc';
        return $this->_a;
    }
    public function  print_a(){
        echo '$this->_a:'.$this->_a.'<br/>';
    }
    public function &get_b(){
        $this->b='cde';
        return $this->b;
    }

    public function print_b(){
        echo '$this->_b:'.$this->b.'<br/>';
    }
}

$temp = new temp_a();

//普通调用
$a = $temp->get_a();
echo '$a:'.$a.'<br/>';
$a='ssss';
$temp->print_a();

//获取引用
$a = &$temp->get_a();
echo '$a:'.$a.'<br/>';
$a='ssss';
$temp->print_a();

//公共成员

$b = $temp->get_b();
echo '$b:'.$b.'<br/>';
$b='ssss';
$temp->print_b();

$b = &$temp->get_b();
echo '$b:'.$b.'<br/>';
$b='ssss';
$temp->print_b();