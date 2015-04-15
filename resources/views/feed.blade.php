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
                        <a class="it-post-likes-link it-link-no-hover {{ $post->isUserHasLiked() ?'liked':'' }}" href="javascript:void(0)">
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
                        <div class="it-post-comment">
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
                        <div class="it-post-comment">
                            <a href="javascript:void(0)">
                                <div class="it-post-comment-avatar it-thumbnail">
                                    <div class="it-thumbnail-i"></div>
                                </div>
                            </a>
                            <a class="it-post-comment-author it-link-no-hover" href="javascript:void(0)">
                                {{$post->getCaption()->getFrom()->getUsername()}}
                            </a>
                            <span class="it-post-comment-text">
                                {{$post->getCaption()->getTranslation()}}
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