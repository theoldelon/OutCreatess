@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>


            <div class="col-lg-9">
                
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                    <i class="material-icons">close</i>
                </span>
            </div>
        @endif
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fs-4 mb-1">My Jobs</h3>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $job)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name font-semibold">{{ $job->title }}</div>
                                            <div class="info1 text-muted">{{ $job->jobType->name }} &bull; {{ $job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                        <td>0 Applications</td>
                                        <td>
                                            @if ($job->status == 1)
                                            <div class="badge bg-success text-capitalize">active</div>  
                                            @else
                                            <div class="badge bg-danger text-capitalize">block</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('jobDetail', $job->id) }}">
                                                            <i class="material-icons">visibility</i> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('account.editJobs', $job->id) }}">
                                                            <i class="material-icons">edit</i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteJob({{ $job->id }})">
                                                            <i class="material-icons">delete</i> Remove
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">No jobs found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div>
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>

function deleteJob(jobId)
{
    if(confirm("Sure wan`t to delete job?"))
    {
        $.ajax({
            type: "POST",
            url: "{{ route('account.deleteJob') }}",
            data: {jobId: jobId},
            dataType: 'json',
            success: function(response)
            {
                window.location.href='{{ route("account.myJobs") }}';
            }
        
        });
    }
}
</script>
@endsection
