
@if($results->isEmpty())
    <p>No results found.</p>
@else
    <ul>
        @foreach($results as $row)
            <li>
                <a href="{{ url('/study', $row->document_id) }}">{{ $row->title }}</a>

                <p>Authors: 
                    @php
                        $authors = is_string($row->authors) ? json_decode($row->authors, true) : $row->authors;
                    @endphp
                    {{ is_array($authors) ? implode(', ', $authors) : $authors }} 
                    ({{ $row->publication_year }})
                </p>

                <p>Keywords: 
                    @php
                        $keywords = is_string($row->keywords) ? json_decode($row->keywords, true) : $row->keywords;
                    @endphp
                    {{ is_array($keywords) ? implode(', ', $keywords) : $keywords }}
                </p>

                <p>Study Type: 
                    @php
                        $studyType = is_string($row->study_type) ? json_decode($row->study_type, true) : $row->study_type;
                    @endphp
                    {{ is_array($studyType) ? implode(', ', $studyType) : $studyType }}
                </p>
            </li>
        @endforeach
    </ul>
@endif