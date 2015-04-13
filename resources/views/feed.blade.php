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
                    <div class="it-post-photo it-thumbnail">
                        <div class="it-post-photo-container it-thumbnail-i"
                             style="background-image:url({{ $post['images']['standard_resolution']['url'] }});"></div>
                    </div>
                    <div class="it-post-likes">
                        <a class="it-post-likes-link it-link-no-hover {{ $post['user_has_liked'] ?'liked':'' }}" href="javascript:void(0)">
                            <div class="it-post-likes-link-text">
                                {{ $post['user_has_liked'] ?'Liked':'Like' }}
                            </div>
                        </a>
                        <div class="it-post-likes-list">
                            <span>
                                {{ number_format($post['likes']['count'], 0, ',', ' ') }} likes
                            </span>
                        </div>
                    </div>
                    <div class="it-post-comments">
                        <div class="it-post-comment">
                            <a href="javascript:void(0)">
                                <div class="it-post-comment-avatar it-thumbnail">
                                    <div class="it-thumbnail-i"
                                         style="background-image:url({{ $post['caption']['from']['profile_picture'] }});"></div>
                                </div>
                            </a>
                            <a class="it-post-comment-author it-link-no-hover" href="javascript:void(0)">
                                {{$post['caption']['from']['username']}}
                            </a>
                            <span class="it-post-comment-text">
                                {{$post['caption']['text']}}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            <!--<pre>{{var_export($post)}}</pre>-->
        </div>
    @empty
        <p>No posts yet</p>
    @endforelse
@stop