<section class="content">
    <h1 id="contact">
        <i class="fa fa-share-alt-square"></i>
        {{ trans('ocv.contact_me') }}
        @if(checkIfAdmin())
            <a id="btnEditContacts"
               href="javascript:void(0);"
               class="btn btn-danger"/>
            <i class="fa fa-edit"></i>
            {{ trans('ocv.edit') }}
            </a>
            <img class="contact-loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
            <!--<input id="isContactEnabled"  checked data-toggle="toggle" data-size="normal" type="checkbox">-->
        @endif
    </h1>




    <div class="row">
        <div id="contact-tell" class="col-lg-4 col-lg-offset-2 text-center">
            @if(isset(getContactTell()->tell))
                <i class="fa fa-phone fa-3x sr-contact"></i>
                <p class="open-sans">
                    {{ getContactTell()->tell }}
                </p>
            @endif
        </div>
        <div id="contact-email" class="col-lg-4 text-center">
            @if(isset(getContactEmail()->email))
            <i class="fa fa-envelope-o fa-3x sr-contact"></i>
            <p>
                <a class="open-sans" href="mailto:{{ getContactEmail()->email }}">
                    {{ getContactEmail()->email }}
                </a>
            </p>
            @endif
        </div>
    </div>




    <div class="row" id="social-ul">
        <div class="col-md-4 col-md-offset-4 text-center">
            <div class="socials">
                <ul class="list-inline">

                    <li id="contact-fb" @if(!isset(getSocial()->fb)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->fb))
                            <a href="{{ getSocial()->fb }}" class="fb" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-tw" @if(!isset(getSocial()->tw)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->tw))
                            <a href="{{getSocial()->tw}}" class="tw" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-yt" @if(!isset(getSocial()->yt)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->yt))
                            <a href="{{getSocial()->yt}}" class="yt" target="_blank">
                                <i class="fa fa-youtube"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-ig" @if(!isset(getSocial()->ig)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->ig))
                            <a href="{{getSocial()->ig}}" class="ig" target="_blank">
                                <i class="fa fa-instagram"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-li" @if(!isset(getSocial()->li)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->li))
                            <a data-social="li" href="{{getSocial()->li}}" class="tg" target="_blank">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-gh" @if(!isset(getSocial()->gh)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->gh))
                            <a data-social="gh" href="{{getSocial()->gh}}" class="gh" target="_blank">
                                <i class="fa fa-github"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-pn" @if(!isset(getSocial()->pn)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->pn))
                            <a data-social="pn" href="{{getSocial()->pn}}" class="pin" target="_blank">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-tg" @if(!isset(getSocial()->tg)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->tg))
                            <a data-social="tg" href="{{getSocial()->tg}}" class="tg" target="_blank">
                                <i class="fa fa-paper-plane"></i>
                            </a>
                        @endif
                    </li>


                    <li id="contact-gp" @if(!isset(getSocial()->gp)) data-enable="false" class="hidden" @else data-enable="true" @endif>
                        @if(isset(getSocial()->gp))
                            <a data-social="gp" href="{{ getSocial()->gp }}" class="gp" target="_blank">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        @endif
                    </li>

                </ul>
            </div>
        </div>
    </div>

</section>



<!-- Edit Contact Modal -->
@include('templates.modals.modal-contact')