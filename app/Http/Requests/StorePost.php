<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
      'title' => 'bail|min:5|max:100|required',
      'content' => 'bail|min:10|max:10000|required',
      'thumbnail' => 'file|image|max:10240|dimensions:min_height=500,min_width=500,max_height=2500,max_width=3000',
    ];
  }

  public function messages()
  {
    return [
      'thumbnail.max' => 'The image can\'t be bigger than 10Mb'
    ];
  }
}
