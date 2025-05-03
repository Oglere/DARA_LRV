<style>
    li {
        gap: 1px;
        margin-bottom: 15px;
    }

    p, .left1, .right1{
        font-size: small;
        margin: 0;
    }

    .left1, .right1 {
        color: grey;
        font-weight: lighter;
        width: 50%;
    }

    a {
        width: initial;
    }
    .gr {
        display: flex;
    }
</style>
@if($results->isEmpty())
    <p>No results found.</p>
@else
    <ul>
    @foreach($results as $row)
        <li>
            <a href="{{ url('/study', $row->document_id) }}">{{ $row->title }}</a>

            <div class="gr">
                <div color="black !important" class="left1">
                    <p><strong>Authors:</strong> {{ $row->last_name }} ({{ $row->publication_year }})</p>
                </div>
                <div class="right1">
                    Approved by {{ $row->teacher_id }} at {{ $row->date_submitted }}
                </div>
            </div>
            <div class="gr" >
                <div class="left1">
                    <strong>Keywords: </strong>
                    @php
                        $keywords = is_string($row->keywords) ? json_decode($row->keywords, true) : $row->keywords;

                        if (!is_array($keywords)) {
                            $keywords = explode(',', $row->keywords);
                        }

                        $keywords = array_map('trim', $keywords);
                    @endphp

                    @if (empty(array_filter($keywords)))
                        No Keywords
                    @else
                        {{ implode(', ', $keywords) }}
                    @endif
                </div>
                <div class="right1">
                    <Strong>Study Type: </Strong>
                    @php
                        $studyType = is_string($row->study_type) ? json_decode($row->study_type, true) : $row->study_type;
                        if (!is_array($studyType)) {
                            $studyType = explode(',', $row->study_type);
                        }
                    @endphp
                    {{ implode(', ', array_map('trim', $studyType)) }}
                </div>
            </div>

        </li>
    @endforeach

    </ul>
@endif