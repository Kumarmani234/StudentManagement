<?php

namespace App\Livewire;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\AddStudentMark;

class AddStudentMarks extends Component {
    public $class;
    public $classes = [];
    public $studentsData = [];

    public function saveAllStudents() {
        $rules = [
            'class' => 'required|string',
        ];

        foreach ( $this->studentsData as $index => $studentData ) {
            $rules[ "studentsData.{$index}.studentIds" ] = [
                'required',
                'numeric',
                Rule::unique( 'add_student_marks', 'std_id' )
                ->ignore( $studentData[ 'studentIds' ] )
            ];
            $rules[ "studentsData.{$index}.studentNames" ] = 'required|string';
            $rules[ "studentsData.{$index}.englishMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.teluguMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.mathsMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.scienceMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.biologyMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.socialMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.computerMarks" ] = 'required|numeric|max:100';
            $rules[ "studentsData.{$index}.totalMarks" ] = 'required|numeric|max:700';
            $rules[ "studentsData.{$index}.percentage" ] = 'required';
            $rules[ "studentsData.{$index}.result" ] = 'required|string';
        }

        $this->validate( $rules );

        try {
            foreach ( $this->studentsData as $index => $studentData ) {
                AddStudentMark::create( [
                    'class' => $this->class,
                    'std_id' => $studentData[ 'studentIds' ],
                    'std_name' => $studentData[ 'studentNames' ],
                    'eng_marks' => $studentData[ 'englishMarks' ],
                    'tel_marks' => $studentData[ 'teluguMarks' ],
                    'maths_marks' => $studentData[ 'mathsMarks' ],
                    'science_marks' => $studentData[ 'scienceMarks' ],
                    'biology_marks' => $studentData[ 'biologyMarks' ],
                    'social_marks' => $studentData[ 'socialMarks' ],
                    'computer_marks' => $studentData[ 'computerMarks' ],
                    'total_marks' => $studentData[ 'totalMarks' ],
                    'percentage' => $studentData[ 'percentage' ],
                    'result' => $studentData[ 'result' ],
                ] );
            }

            session()->flash( 'message', 'All Students\' Marks Added Successfully.');
        return redirect()->to('/AddStudentMarksDetails');
    } catch (\Exception $e) {
        session()->flash('error', 'An error occurred while saving students\' marks: ' . $e->getMessage() );
        }
    }

    public function saveStudentMarks( $index ) {

        $this->validate( [
            'class' => 'required|string',
            'studentsData.*.studentIds' => [
                'required',
                'numeric',
                Rule::unique( 'add_student_marks', 'std_id' )->ignore( $this->studentsData[ $index ][ 'studentIds' ] ),
            ],

            'studentsData.' . $index . '.studentNames' => 'required|string',
            'studentsData.' . $index . '.englishMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.teluguMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.mathsMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.scienceMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.biologyMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.socialMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.computerMarks' => 'required|numeric|max:100',
            'studentsData.' . $index . '.totalMarks' => 'required|numeric|max:700',
            'studentsData.' . $index . '.percentage' => 'required',
            'studentsData.' . $index . '.result' => 'required',
        ] );

        $studentData = $this->studentsData[ $index ];
        AddStudentMark::create( [
            'class' => $this->class,
            'std_id' => $studentData[ 'studentIds' ],
            'std_name' => $studentData[ 'studentNames' ],
            'eng_marks' => $studentData[ 'englishMarks' ],
            'tel_marks' => $studentData[ 'teluguMarks' ],
            'maths_marks' => $studentData[ 'mathsMarks' ],
            'science_marks' => $studentData[ 'scienceMarks' ],
            'biology_marks' => $studentData[ 'biologyMarks' ],
            'social_marks' => $studentData[ 'socialMarks' ],
            'computer_marks' => $studentData[ 'computerMarks' ],
            'total_marks' => $studentData[ 'totalMarks' ],
            'percentage' => $studentData[ 'percentage' ],
            'result' => $studentData[ 'result' ],
        ] );
        session()->flash( 'message', 'Student Marks Added Successfully.' );
        return redirect()->to( '/AddStudentMarksDetails' );
    }

    public function addStudentRow() {
        $this->studentsData[] = [
            'studentIds' => null,
            'studentNames' => null,
            'englishMarks' => null,
            'teluguMarks' => null,
            'mathsMarks' => null,
            'scienceMarks' => null,
            'biologyMarks' => null,
            'socialMarks' => null,
            'computerMarks' => null,
            'totalMarks' => null,
            'percentage' => null,
            'result'=>null,
        ];
    }

    public function calculateTotal( $index ) {
        $studentData = $this->studentsData[ $index ];
        $totalMarks = array_sum( [
            $studentData[ 'englishMarks' ],
            $studentData[ 'teluguMarks' ],
            $studentData[ 'mathsMarks' ],
            $studentData[ 'scienceMarks' ],
            $studentData[ 'biologyMarks' ],
            $studentData[ 'socialMarks' ],
            $studentData[ 'computerMarks' ],
        ] );

        $this->studentsData[ $index ][ 'totalMarks' ] = $totalMarks;
        $percentage = ( $totalMarks / 700 ) * 100;
        $this->studentsData[ $index ][ 'percentage' ] = number_format( $percentage, 2 );
        if ($totalMarks < 245||( $studentData[ 'englishMarks' ]<35|| $studentData[ 'teluguMarks' ]<35||
        $studentData[ 'mathsMarks' ]<35||$studentData[ 'scienceMarks' ]<35|| $studentData[ 'biologyMarks' ]<35
        ||$studentData[ 'socialMarks' ]<35||$studentData[ 'computerMarks' ]<35)) {
            $this->studentsData[ $index ][ 'result' ] = 'Fail'; 
        } else {
            $this->studentsData[ $index ][ 'result' ] = 'Pass';
   
        }
        $this->skipRender();
    }

    public function render() {
        $this->classes = Student::distinct( 'class' )->pluck( 'class' )->toArray();

        if ( !empty( $this->class ) ) {
            $students = Student::where( 'class', $this->class )->get();

            $this->studentsData = [];

            foreach ( $students as $student ) {
                $this->studentsData[] = [
                    'studentIds' => $student->std_id,
                    'studentNames' => $student->std_first_name,
                    'englishMarks' => null,
                    'teluguMarks' => null,
                    'mathsMarks' => null,
                    'scienceMarks' => null,
                    'biologyMarks' => null,
                    'socialMarks' => null,
                    'computerMarks' => null,
                    'totalMarks' => null,
                    'percentage' => null,
                    'result'=>null,
                ];
            }
        } else {
            $this->studentsData = [];
        }

        return view( 'livewire.add-student-marks' );
    }

}

