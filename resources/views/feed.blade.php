@extends('layout.in')
@section('content')
    @forelse ($data->getData() as $post)
        <div class="block">
            <div class="it-post-sidebar">
                <div class='it-post-sidebar-note'>
                    <div class="it-sidebar-user text-right">
                        <div class="it-sidebar-user-name">
                            <p>{{$post->getUser()->getUsername()}}</p>
                        </div>
                        <div class="it-sidebar-user-date">
                            <p>{{date("Y-m-d H:i:s", $post->getCreatedTime())}}</p>
                        </div>
                    </div>
                    <div class="it-sidebar-avatar">
                        <div class="it-sidebar-avatar-image"
                             style="background-image:url({{ $post->getUser()->getProfilePicture()}});"></div>
                    </div>
                </div>
            </div>
            <div class="block it-post-center">
                <div class="it-post-item">
                    <div class="it-post-photo it-thumbnail">
                        <div class="it-post-photo-container it-thumbnail-i"
                             style="background-image:url({{ $post->getImages()->getStandardResolution()->getUrl()}});"></div>
                    </div>
                    <div class="it-post-likes">
                        <a class="it-post-likes-link it-link-no-hover {{ $post->isUserHasLiked() ?'liked':'' }}"
                           href="javascript:void(0)">
                            <div class="it-post-likes-link-text">
                                {{ $post->isUserHasLiked() ?'Liked':'Like' }}
                            </div>
                        </a>

                        <div class="it-post-likes-list">
                            <span>
                                {{ number_format($post->getLikes()->getCount(), 0, ',', ' ') }} likes
                            </span>
                        </div>
                    </div>
                    <div class="it-post-comments">
                        @if($post->getCaption())
                            <div class="translatable translatable__caption translatable_translated_no">
                                <div class="it-post-comment translatable__source"
                                     data-mediaid="{{$post->getCaption()->getId()}}"
                                     data-userid="{{$post->getCaption()->getFrom()->getId()}}">
                                    <a href="javascript:void(0)">
                                        <div class="it-post-comment-avatar it-thumbnail">
                                            <div class="it-thumbnail-i"
                                                 style="background-image:url({{ $post->getCaption()->getFrom()->getProfilePicture() }});"></div>
                                        </div>
                                    </a>
                                    <a class="it-post-comment-author it-link-no-hover" href="javascript:void(0)">
                                        {{$post->getCaption()->getFrom()->getUsername()}}
                                    </a>
                                    <span class="it-post-comment-text">
                                        {{$post->getCaption()->getText()}}
                                    </span>
                                </div>
                                <div class="it-post-comment translatable__translation">
                                    <a href="javascript:void(0)">
                                        <div class="it-post-comment-avatar it-thumbnail">
                                            <div class="it-thumbnail-i"></div>
                                        </div>
                                    </a>

                                    <span class="it-post-comment-text"></span>
                                </div>
                            </div>
                        @endif
                            <div class="it-scroll-area">
                                <div class="it-scroll-area-content">
                                    @foreach($post->getComments()->getData() as $comment)
                                        <div class="translatable translatable__comment translatable_translated_no">
                                            <div class="it-post-comment translatable__source"
                                                 data-mediaid="{{$comment->getId()}}"
                                                 data-userid="{{$comment->getFrom()->getId()}}">
                                                <a href="javascript:void(0)">
                                                    <div class="it-post-comment-avatar it-thumbnail">
                                                        <div class="it-thumbnail-i"
                                                             style="background-image:url({{ $comment->getFrom()->getProfilePicture() }});"></div>
                                                    </div>
                                                </a>
                                                <a class="it-post-comment-author it-link-no-hover"
                                                   href="javascript:void(0)">
                                                    {{$comment->getFrom()->getUsername()}}
                                                </a>
                                                <span class="it-post-comment-text">
                                                    {{$comment->getText()}}
                                                </span>
                                            </div>
{{--                                        @if($comment->isTranslated())--}}
                                            <div class="it-post-comment translatable__translation it-post-comment__light-border">
                                                <a href="javascript:void(0)">
                                                    <div class="it-post-comment-avatar it-thumbnail">
                                                        <div class="it-thumbnail-i"></div>
                                                    </div>
                                                </a>
                                                <span class="it-post-comment-text"></span>
                                            </div>
                                        {{--@endif--}}
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="it-comment-creator">
                                <div class="it-comment-creator_text">
                                    <form class="it-comment-form">
                                        <input type="text" placeholder="Написать комментарий…"
                                               class="it-comment-form_input it-comment-form_input__faded ">
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <p>No posts yet</p>
    @endforelse
@stop