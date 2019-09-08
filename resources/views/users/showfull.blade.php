@section('title')
HERMES - User / {{$user->name}}
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/users.js') }}"></script>
@endsection

@extends('layouts.layout')

@section('content')

  @if($user->type == "b")
    <div class="position-relative overflow-hidden text-center bg-light" 
    {{--
      style="background-image: linear-gradient(to bottom right, 
        @foreach($colors as $color_value) 
        #{{$color_value}}
        @if(!$loop->last)
        ,
        @endif
        @endforeach );--}}">

        <div class="float-right p-3">
          {{--@if(!auth()->user()->hasFriend($user->id) && auth()->user()->id != $user->id && $user->type != "b")
          <button class="add_friend btn btn-primary" value="{{$user->id}}"><i class="fas fa-user-plus"></i> Add as Friend</button>
          @endif--}}

          @if(auth()->user()->id != $user->id)
            @if(!auth()->user()->hasFriend($user->id))
              <button class="add_friend btn btn-primary" value="{{$user->id}}"><i class="fas fa-user-plus"></i> Add Friend</button>
            @else
              <button class="delete_friend btn btn-danger" value="{{auth()->user()->areFriends($user->id)}}"><i class="fas fa-trash-alt"></i> Remove Friend</button>
            @endif
          @endif

          @if(auth()->user()->id != $user->id)

          @if($user->type == "b")
          <a class="message_user btn btn-primary" href="/conversations/{{$user->id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>
          @elseif(auth()->user()->areFriends($user->id))
          <a class="message_user btn btn-primary" href="/conversations/{{$user->id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>
          @endif

          <button class="add_user_to_favorites btn {{$user->inFavorite()?'btn-danger':'btn-warning'}} " value="{{$user->id}}"><i class="fas fa-star"></i>{{$user->inFavorite()?' Remove':' Add'}} Favorite</button>

          @endif

          @if(auth()->user()->id == $user->id)
          <a href="/users/{{$user->id}}/edit" class="btn btn-warning"><i class="fas fa-user-cog"></i> Edit Profile</a>
          @endif  
        </div>

        <div class="col-md-7 p-lg-5 mx-auto ">

          <h1 class="display-4 font-weight-normal">
            <div class="">
              <div class="row no-gutters">
                <div class="col-auto">
                  <div class="float-left">
                    @if($user->details->file_name != null)
                    <img class="m-0 p-0 ml-1 mr-1 border" src="{{url('uploads/'.$user->details->file_name)}}" style='height: 200px; width: 200px; border-radius: 50%; object-fit: cover;'>
                    @else
                    <div class="m-0 p-0 ml-1 mr-1 " style="height: 145px; width: 145px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 145px;"></i></div>
                    @endif
                  </div>
                </div>
                <div class="col">
                  <div class="card-block px-2 pl-4" style="text-align: left;">
                    <p class="card-text">{{$user->name}}</p>

                    <p class="lead font-weight-normal">{{$user->details->description}}</p>
                  </div>
                </div>
              </div>
            </div>
          </h1>
        </div>

      </div>

      @foreach($offers as $offer)
      <div class="show_offer text-dark" href="/offers/{{$offer->id}}" onclick="location.href = '/offers/{{$offer->id}}';" style="text-decoration: none;">
        <div class="float-left w-50 my-md-3 pl-md-3 h-100">
          <div class="bg-light mr-md-3 pt-3 px-3 px-md-5 text-center overflow-hidden" style="border-radius: 21px 21px 21px 21px;">
            <div class="my-3">
              @if($offer->user_id == auth()->user()->id)
                  <a class="float-right d-inline-block" href="/offers/{{$offer->id}}/edit" onclick="location.href = '/offers/{{$offer->id}}/edit';"><i class="fas fa-edit"></i> Edit</a>
              @endif
              <h2 class="display-5 w-100">{{$offer->name}}</h2>
              <p class="lead" style="text-align: center; height: 30px; text-overflow: ellipsis; width: 100%; overflow:hidden; white-space:nowrap;">{{$offer->description}}</p>
            </div>
            <div class="shadow mx-auto" style='width: 80%; height: 300px; border-radius: 21px 21px 0 0; background-image: url("{{url('uploads/'.$offer->images->first()->file_name)}}"); background-repeat:no-repeat; background-size:cover; background-position: top center;'></div>
          </div>
        </div>
      </div> 
      @endforeach

    @else

      @include('users.consumerprofile')

    @endif

      @include('errors')
  @endsection