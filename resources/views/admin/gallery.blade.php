@if (in_array($edit->status, ['modify', 'create']))
    <div class="panel panel-default">
        <div class="panel-heading">Gallery</div>
        <div class="panel-body">
            <input type="file" name="gallery[]" multiple />
            <label>
                Only jpg, jpeg, png are allowed.
            </label>
        </div>
    </div>
@endif

@if(!empty($gallery))
    <div class="row">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Upload images') }}</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>{{ __('Image') }}</th>

                            @if(in_array($edit->status, ['modify']))
                                <th style="width: 40px">{{ __('Remove') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gallery as $k => $item)
                            <tr>
                                <td>{{ ($k + 1) }}.</td>
                                <td>
                                    <img src="{{ $item['file'] }}" style="max-width: 150px; max-height: 150px;" alt="{{ $item['file'] }}" />
                                </td>

                                @if(in_array($edit->status, ['modify']))
                                    <td>
                                        <label>
                                            <input type="checkbox" name="delete_gallery_item[{{ $item['id'] }}]" value="1" />
                                        </label>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
