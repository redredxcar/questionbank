<?php

namespace core_qb;

 class QuestionTypeGroup
{
    /**
     * Data Structure:
     * {
     *    quesType: string,
     *    requiredNumber: int,
     *    questionArr： array{
     *      Question_obj1: Object,
     *      Question_obj2: Object
     *    }
     * }
     */
    
    private $quesType, $required_number, $questionArr;
    
    public function __construct($_quesType, $_required_number = 0)
    {
        $this->quesType = $_quesType;
        $this->required_number = $_required_number;
        $this->questionArr = array();
    }
    
    public function add_question(Question $question)
    {
        $this->questionArr[] = $question;
        
    }
    public function __get($property_name){
        if(isset($this->$property_name))
        {
            return($this->$property_name);
        }else
        {
            return(NULL);
        }
    }
    //__set()方法用来设置私有属性
     function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }
    
    public function getQuestionCount(){
        return count( $this->questionArr);
    }
    
    public function questionId_exists($questionId){
        foreach($this->questionArr as $vl){
            if($vl->questionId == $questionId){
                return true;
            }
        }
        return false;
    }
    
    public function remove_question($questionId){
        foreach($this->questionArr as $vl){
            if ($vl->questionId == $vl){
                // remove the question from group array;
                remove_Array_Value($this->questionArr, $vl);
                break;
            }
        }
    }

    /**
     * return a list of question id.
     * @return array
     */ 
    public function getQuestionIdList(){
        $questionIdArr = array();
        foreach($this->questionArr as $question){
            $questionIdArr[] = $question->questionId;
        }
        return $questionIdArr;
    }
 }