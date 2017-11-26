<?php


/**
 *
 * 抽象类名和方法都必须用abstract
 * 抽象类不可以实例化,想使用，就必须用一个类去继承他，并且把他所有的
 * 抽象方法全部重写
 *
 * * 内存：
 * 栈内存：速度快，存大小固定的，固有空间小 如：整形
 * 堆内容：存不固定的，固有空间大 如：字符串，对象，数组
 * 代码段：方法，函数， if语句 结构等等
 * 数据段：静态变量，常量共用的东西
    self  用来访问当前类中的内容的关键字，类似 $this 关键字，但 $this 需要类实例化以后才可以使用
    self 值可以访问静态属性，方法静态不静态都可以
    同理：parent用来访问父类的静态属性或所有方法
 *
 */
abstract class man1
{

    //子类的成员属性级别必须等于或弱于父类的
    public $a = '';

    //这样的函数为抽象函数，没有{}
    abstract public function say();

    abstract public function eat();

    //也可以有不抽象的方法
    public function run()
    {

    }    //对于静态的方法可以直接调用，只要不new就不会报错 man1::hello();

    public static function hello()
    {
        echo "hello";
    }
}


/**
 * 如果子类不完全实现里面的抽象方法，则仍为抽象类，类名中需要带abstract
 * 如果都实现了，则为一个正常的类了
 *
 * 目的：把你自己写的程序模块，加入到已经写好的程序中去，可以不用等你完成
 * 给别人写一个规范，自己安装这来写，其他人也安装这个来写
 *
 */
abstract class man2 extends  man1{

    //也可以有不抽象的方法
    public function run()
    {

    }
}

/**
 * 接口：php中的类是单继承的，如果想多继承必须用接口实现
 * 作用和抽象类相同|被实现的方式不一样 |接口中所有的方法都必须是抽象方法|
 * 成员属性只能声明常量|访问权限必须都是public
 *
 */

interface demo{
    const user="song";

    //必须是公有的
    public function say();

}

interface demo2 extends demo{
    public function run();
}


interface demo5 {
    public function drink();
}

//可以用抽象类来实现接口中的部分方法
abstract class demo3 implements demo2{
    abstract public function jump();    //可以增加新的抽象方法
}


class people{

}

//想让子类可以创建对象，必须全部实现它,可以同时继承多个接口
class demo4 extends people implements demo2,demo5{

    public function say(){

    }
    public function run(){

    }

    public function drink(){

    }
}
//因为常量不用实例化对象
echo demo::user;

//用接口实现了php的多态（调用不同对象的相同函数，实现了不同的效果）