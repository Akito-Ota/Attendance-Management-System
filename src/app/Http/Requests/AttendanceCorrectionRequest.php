<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCorrectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_time' => ['required', 'date_format:H:i', 'before:end_time'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'rest_start' => ['nullable', 'date_format:H:i', 'before:end_time', 'after:start_time'],
            'rest_end'   => ['nullable', 'date_format:H:i', 'before:end_time', 'after:rest_start'],
            'rest_start2' => ['nullable', 'date_format:H:i', 'before:end_time','after:rest_end'],
            'rest_end2'   => ['nullable', 'date_format:H:i', 'before:end_time','after:rest_start2'],
            'remark'     => ['required', 'string', 'max:255'],
        ];
    }
    public function messages()
    {
        return [
            'start_time.required' => '出勤時間が不適切な値です',
            'start_time.before' => '出勤時間もしくは退勤時間が不適切な値です',
            'end_time.after'    => '出勤時間もしくは退勤時間が不適切な値です',
            'end_time.required' =>'退勤時間が不適切な値です',
            'rest_start.before' => '休憩時間が不適切な値です',
            'rest_start.after' => '休憩時間が不適切な値です',
            'rest_end.before'   => '休憩時間もしくは退勤時間が不適切な値です',
            'rest_end.after' => '休憩時間もしくは退勤時間が不適切な値です',
            'rest_start2.before' => '休憩時間が不適切な値です',
            'rest_end2.before'   => '休憩時間もしくは退勤時間が不適切な値です',
            'rest_start2.after' => '休憩時間が不適切な値です',
            'rest_end2.after'   => '休憩時間もしくは退勤時間が不適切な値です',
            'remark.required'    => '備考を記入してください', 
            'remark.max'        =>'備考が長すぎます'
        ];
    }
}
