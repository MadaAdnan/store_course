
@extends('layouts.master')

@section('content')
   <table>
       <tr>
           <td>الاسم</td>
           <td>البريد</td>
           <td>رقم الهاتف</td>
       </tr>

       @foreach($users as $user)
           <tr>
               <td>{{$user->name}}</td>
               <td>{{$user->email}}</td>
               <td>{{$user->phone}}</td>
           </tr>

       @endforeach
   </table>

{{$users->links()}}
   <form action="{{route('users.store')}}" method="post">
       @csrf
       @method('post')
       <input type="text" name="name">
       <button>إرسال</button>
   </form>
@endsection
