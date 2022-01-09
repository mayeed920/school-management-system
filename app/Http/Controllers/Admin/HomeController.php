<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'        => 'students per class',
            'chart_type'         => 'bar',
            'report_type'        => 'group_by_relationship',
            'model'              => 'App\Models\Student',
            'group_by_field'     => 'class_name',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
            'relationship_name'  => 'class_iid',
            'translation_key'    => 'student',
        ];

        $chart1 = new LaravelChart($settings1);

        $settings2 = [
            'chart_title'        => 'Count of students per country',
            'chart_type'         => 'pie',
            'report_type'        => 'group_by_relationship',
            'model'              => 'App\Models\Student',
            'group_by_field'     => 'name',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
            'relationship_name'  => 'country_code',
            'translation_key'    => 'student',
        ];

        $chart2 = new LaravelChart($settings2);

        $settings3 = [
            'chart_title'        => 'Average age of students',
            'chart_type'         => 'number_block',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Student',
            'group_by_field'     => 'date_of_birth',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
            'translation_key'    => 'student',
        ];



        $age_sum = 0;
        $dateOfBirth = DB::select('select date_of_birth from students');
        foreach ($dateOfBirth as $key => $years )
            $years = Carbon::parse($key)->age;

        $age_sum = $age_sum + $years;

        $students_count = Student::count();

        $age_average = $age_sum / $students_count;

        $settings3['total_number'] = $age_average;



        return view('home', compact('chart1', 'chart2', 'settings3'));
    }
}
