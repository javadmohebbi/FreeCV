<section id="bioSection" class="content" style="min-height: 320px">
    <h1 id="bio">
        <i class="fa fa-question-circle"></i>
        {{ trans('ocv.bio_and_about_me') }}

        @if(checkIfAdmin())
            <a id="btnEditBio"
               href="javascript:void(0);"
               class="btn btn-danger"/>
                <i class="fa fa-edit"></i>
                {{ trans('ocv.edit') }}
            </a>
            <!--<input id="isBioEnabled"  checked data-toggle="toggle" data-size="normal" type="checkbox">-->
        @endif

    </h1>
    <p class="text-justify">
        <div class="bio-img-container @if(isRTL()) pull-right @else pull-left @endif"
             style="max-width: 200px;  @if(isRTL()) margin-left:30px; @else margin-right: 30px; @endif margin-bottom: 30px"
        >
            <img id="imgBio" class="img-circle img-responsive" src="{{ getBioImage() }}"
                 style="border: 1px solid #8c8c8c;width: 100%"
                 >

        @if(checkIfAdmin())
            <div class="btnEditBioImage overlay img-circle" style="cursor: pointer"></div>
            <div class="button btnEditBioImage" style="cursor: pointer">
                <a id="btnEditBioImage" class="btnEditBioImage" href="javascript:void(0);">
                    <i class="fa fa-camera" style="font-size: 300%;"></i>
                </a>
            </div>
        @endif
        </div>
        <div class="text-justify" id="bio-para">
            <p>
            @if(getBio() != false)
                {!! getBio()->bio !!}
            @else
                {{ trans('ocv.bio_default')}}
            @endif
            </p>
        </div>


    </p>
</section>






<!-- Edit Modal -->
@include('templates.modals.modal-bio')

<!-- Edit Image Modal -->
@include('templates.modals.modal-bio-image')




