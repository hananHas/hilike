@extends('admin.layouts.master')

@section('content')
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
    /* width */
    #chat_page::-webkit-scrollbar {
      width: 10px;
    }
    
    /* Track */
    #chat_page::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    #chat_page::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Handle on hover */
    #chat_page::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    .chat-footer {
      position: absolute;
      left: 35%;
      right: 2%;
      bottom: 2%;
      background-color: #f1f4f6;
    }   

    .cat_name {
      color: red;
      border: 1px solid red;
      padding-top: 0.5em;
    }       
</style>

<div id="vue-app" class="app-inner-layout chat-layout">
    <chat-page :chat-id="{{isset($chat) ? $chat->id : 0}}" :user-id="{{Auth::id()}}"></chat-page>
</div>

@push('scripts')
  <script>
  $('.app-main__inner').addClass('p-0');
  </script>

@endpush

@endsection
