<section class="content">
    <!-- BEGIN SKILLS -->
    <h1 id="skills">
        <i class="fa fa-check-square"></i>
        {{ trans('ocv.skills') }}
        @if(checkIfAdmin())
            <a id="btnAddNewSkill"
               href="javascript:void(0);"
               class="btn btn-danger"/>
            <i class="fa fa-edit"></i>
            {{ trans('ocv.add') }}
            </a>
            <img class="skill-loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
            <!--<input id="isSkillEnabled"  checked data-toggle="toggle" data-size="normal" type="checkbox">-->
        @endif
    </h1>
    <div class="row" id="skill-container">
        @if (count(getSkills()->toArray()) > 0)
            @foreach(getSkills() as $index => $skill)
                <div id="skill-{{$skill->id}}" class="col-sm-6 col-md-4">
                    @if (checkIfAdmin())
                        <div id="skill-{{$skill->id}}" class="btn-group @if (isRTL()) pull-left @else pull-right @endif" style="margin-top: 4px; margin-left: 2px; margin-right: 2px">
                            <a data-id="{{$skill->id}}" class="btn btn-info btn-edit-skill"  href="javascript:void(0);">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-id="{{$skill->id}}" class="btn btn-danger btn-del-skill" href="javascript:void(0);">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @endif
                    <div  class="progress">
                        <div class="progress-bar progress-bar-striped {{ getColorCssClass($skill->color) }}" role="progressbar"
                             aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $skill->percentage }}%">
                        </div>
                    </div>
                    <div class="progress-text" title="{{ $skill->skill }}">
                        {{ $skill->skill }}
                    </div>
                </div>
            @endforeach
        @endif





    </div>
    <!-- E N D SKILLS -->
</section>


<!-- Add New Skill Modal -->
@include('templates.modals.modal-skills-add')

<!-- Edit Skill Modal -->
@include('templates.modals.modal-skills-edit')