<section id="eduSection" class="content"  style="background: white">
    <!-- BEGIN Project -->
    <h1 id="experiences">
        <i class="fa fa-mortar-board"></i>
        {{ trans('ocv.experiences_and_education') }}
        @if(checkIfAdmin())
            <a id="btnAddNewEdu"
               href="javascript:void(0);"
               class="btn btn-danger"/>
            <i class="fa fa-plus"></i>
            {{ trans('ocv.add') }}
            </a>

            <!--<input id="isEduEnabled"  checked data-toggle="toggle" data-size="normal" type="checkbox">-->
        @endif

    </h1>
    @if (count(getExperiences()->toArray()) <= 0)
        <ul class="timeline hidden" id="edu-timeline" style="direction: ltr"></ul>
    @else
        <ul class="timeline" id="edu-timeline" style="direction: ltr">
            @foreach(getExperiences() as $index => $project)
                <li @if($index % 2 == 0) class="timeline-inverted" @endif
                @if(getBadge($project->is_present)) data-year="now" @else data-year="{{ $project->to_year }}" @endif
                    @if(getBadge($project->is_present)) data-month="now" @else data-month="{{ $project->to_month }}" @endif
                    data-order="{{ ++$index }}"
                    @if(getBadge($project->is_present)) data-badge="true" @else data-badge="false" @endif
                    data-skip="false"
                    data-id="{{ $project->id }}"
                    data-from-m="{{ $project->from_month }}"
                    data-from-y="{{ $project->from_year }}"
                    data-to-m="{{ $project->to_month }}"
                    data-to-y="{{ $project->to_year }}"
                    id="edu-id-{{ $project->id }}"
                    @if(isRTL()) style="direction: rtl;text-align: right" @endif
                >
                    <div class="timeline-badge">
                        @if(getBadge($project->is_present)) {{ trans('ocv.now') }} @else {{ $project->to_year }} @endif
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">
                                {{ $project->name }}

                                @if (checkIfAdmin())
                                    <a class="btn btn-info btn-edit-project" href="javascript:void(0);" data-id="{{$project->id}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger btn-del-project" href="javascript:void(0);" data-del-prj="true" data-id="{{$project->id}}">
                                        <i class="fa fa-trash"></i>
                                        <img class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                                    </a>
                                @endif
                            </h4>
                            <p>
                                <small class="text-muted"><i class="glyphicon glyphicon-time"></i>
                                    <span class="data-link-and-time">
                                    {{ getMonthName($project->from_month) }} {{ $project->from_year }} - @if(getBadge($project->is_present)) {{ trans('ocv.now') }} @else {{getMonthName($project->to_month)}} {{ $project->to_year }} @endif  @if ($project->link != null) <a href="{{ $project->link }}" target="_blank" title="{{ $project->name }}">{{ $project->link }}</a>@endif
                                </span>
                                </small>
                            </p>
                        </div>
                        <div class="timeline-body">
                            {!! $project->description !!}
                        </div>
                    </div>

                </li>
            @endforeach


        </ul>
@endif

<!-- E N D Project -->
</section>





<!-- Add New Project Modal -->
@include('templates.modals.modal-edu-add')


<!-- Edit Project Modal -->
@include('templates.modals.modal-edu-edit')