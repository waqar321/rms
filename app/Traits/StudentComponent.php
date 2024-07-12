<?php


namespace App\Traits;

trait StudentComponent
{
    // public $name;
    // public $address;
    // public $dob;
    // public $phone_number;
    // public $gender = "male";
    public $edit=false;
    public $pageTitle = 'Add New Student';
    public $MainTitle = 'Students';
    public $searchByAddress;
    public $searchByNumber;
    public $searchByGender;
    public $searchByDate;
    public $searchByTime;

    public function resetInput()
    {
        $this->ecom_student->name = '';
        $this->ecom_student->address = '';
        $this->ecom_student->dob = '';
        $this->ecom_student->phone_number = '';
        $this->ecom_student->gender = '';    
        $this->searchByAddress = '';
        $this->searchByNumber = '';
        $this->searchByGender = '';
        $this->searchByDate = '';   
        $this->searchByTime = '';   
    }
    protected $rules = [
        // 'ecom_student.name' => 'required|unique:ecom_student|min:2',
        'ecom_student.name' => 'required|min:2',
        'ecom_student.address' => 'required|string|min:20',
        'ecom_student.dob' => 'required|date',
        // 'ecom_student.phone_number' => 'required|unique:ecom_student|digits:11',
        'ecom_student.phone_number' => 'required|digits:11',
        'ecom_student.gender' => 'required|in:male,female',    
    ];

    protected $messages = [
        'ecom_student.name.required' => 'The name cannot be empty.',
        'ecom_student.name.min:2' => 'The name length must be greater than 2.',
        'ecom_student.address.required' => 'The Address cannot be empty.',
        'ecom_student.address.min:2' => 'The address length must be greater than 2.',
    ];


}