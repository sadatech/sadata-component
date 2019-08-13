<div class="alert alert-primary" role="alert">
    <div class="alert-text">{{ $down_title }}</div>
</div>

@if(!empty($sections))
    @foreach ($sections as $section)
        @component('components.alert_title', ['title' => $section['title'], 'grey' => true, 'icon' => $section['icon'], 'repeated' => $section['repeated'], 'id' => ($section['id'] ?? '')])
        @endcomponent

        <div
            @if($section['repeated'] == true)
                id="{{ $section['id'] }}" style="display: none;"
            @endif>
            <table class="table">                
                @foreach ($section['data'] as $detail_key => $detail_data)
                    <tr>
                        <td style="font-weight: bold;">{{ $detail_key }}</td>
                        <td>:</td>
                        @if(is_array($detail_data))
                            @if(!empty($detail_data))
                            <td>
                                <table class="table table-bordered table-striped" style="font-size:9pt;">
                                    <thead>
                                        <tr>
                                            @foreach($detail_data[0] as $item_key => $item_value)
                                                <td style="font-weight: bold;">{{ str_replace('_', ' ', strtoupper($item_key)) }}</td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detail_data as $item)
                                            <tr>
                                                @foreach($item as $item_key => $item_value)
                                                    <td>{{ $item_value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            @else
                                <td>-</td>
                            @endif
                        @else
                            <td>{{ $detail_data }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
@else
    @component('components.alert_title', ['title' => 'No Data Found', 'grey' => true, 'icon' => 'question-circle', 'repeated' => false])
        @endcomponent
@endif
