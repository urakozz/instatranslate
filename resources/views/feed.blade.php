@extends('layout.in')
@section('content')
    @forelse ($data as $post)
        <div class="block">
            <div class="it-post-sidebar">
                <div class='it-post-sidebar-note'>
                    <div class="it-sidebar-user text-right">
                        <div class="it-sidebar-user-name">
                            <p>{{$post['user']['username']}}</p>
                        </div>
                        <div class="it-sidebar-user-date">
                            <p>{{date("Y-m-d H:i:s", $post['created_time'])}}</p>
                        </div>
                    </div>
                    <div class="it-sidebar-avatar">
                        <div class="it-sidebar-avatar-image"
                             style="background-image:url({{ $post['user']['profile_picture'] }});"></div>
                    </div>
                </div>
            </div>
            <div class="block it-post-center">
                <div class="it-post-item">
                    <div class="it-post-photo">
                        <div class="it-post-photo-container"
                             style="background-image:url({{ $post['images']['standard_resolution']['url'] }});"></div>
                    </div>
                </div>
            </div>
            <!--<pre>{{var_export($post)}}</pre>-->
        </div>
    @empty
        <p>No posts yet</p>
    @endforelse
@stop