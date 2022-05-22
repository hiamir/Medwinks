@role('{{$role}}')
    @can($permission)
      {{$slot}}
    @endcan
@endrole
