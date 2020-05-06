<?php
/**
 * Created by PhpStorm.
 * User: manu
 * Date: 08/03/19
 * Time: 19:51
 */

namespace App\Services;


use Doctrine\ORM\Mapping\Id;
use phpDocumentor\Reflection\DocBlock\Description;
use PhpParser\Node\Name;

class EvolutionObject
{
    private $id;
    private $name;
    private $description;
    public function _construct(Id $id,Name $name, Description $description){
        $this->id;
        $this->name;
        $this->description;
    }

    public function doSomething(){

    }

}