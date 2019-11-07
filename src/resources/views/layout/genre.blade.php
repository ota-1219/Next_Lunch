@if(count($genre) > 0)
<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach($genre as $key => $vals)
    <div class="card">
        <div class="card-header alert-warning" role="tab" id="heading_{{ $vals['0']['group_id'] }}">
        <h5 class="mb-0">
            <a class="text-body" data-toggle="collapse" href="#collapse{{ $vals['0']['group_id'] }}" role="button" aria-expanded="true" aria-controls="collapse{{ $vals['0']['group_id'] }}">
                {{ $key }}
            </a>
        </h5>
        </div><!-- /.card-header -->
        <div id="collapse{{ $vals['0']['group_id'] }}" class="collapse" role="tabpanel" aria-labelledby="heading_{{ $vals['0']['group_id'] }}" data-parent="#accordion">
        <div class="card-body">
            <label><input type="checkbox" class="checkall_{{ $vals['0']['group_id'] }}" name="checkall[]" value="{{ $vals['0']['group_id'] }}"
            @if (!is_null(old('checkall')))
                @foreach (old('checkall') as $key => $item)
                    {{ $item == $vals['0']['group_id'] ? 'checked' : '' }}
                @endforeach
            @endif
            ><b>すべてをチェックする</b></label><br>
            @foreach($vals as $key => $val)
                <label>
                    <input type="checkbox" name="genre[]" class="genre_{{ $vals['0']['group_id'] }}" value="{{ $val['id'] }}"
                    @if (!is_null(old('genre')))
                        @for ($i = 0; $i < count(old('genre')); $i++)
                        {{ old('genre.'.$i) == $val['id'] ? 'checked' : '' }}
                        @endfor
                    @elseif(isset($data['genre']))
                        @foreach ($data['genre'] as $key => $item)
                            {{ $item['genre_id'] == $val['id'] ? 'checked' : '' }}
                        @endforeach
                    @else
                    @endif
                    >{{ $val['name'] }}　
                </label>
            @endforeach
        </div><!-- /.card-body -->
        </div><!-- /.collapse -->
    </div><!-- /.card -->
    @endforeach
</div><!-- /#accordion -->
@endif
