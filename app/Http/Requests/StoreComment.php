<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreComment extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Auth::check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'content' => 'required|min:5'
    ];
  }

  public function messages()
  {
    return [
      'content.required' => 'The comment is required',
      'content.min' => 'The comment needs to have at least 5 characteres',
    ];
  }
}
