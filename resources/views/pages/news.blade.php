@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>News Intelligence</h2>

    <h5>{{ $country->name }}</h5>

    <p>

        Logistics • Trade • Shipping • Economy

    </p>

</div>



<div class="row g-4">

    <div class="col-md-4">

        <div class="card-box text-center">

            <h5>😊 Positive</h5>

            <h2>{{ $positive }}</h2>

        </div>

    </div>



    <div class="col-md-4">

        <div class="card-box text-center">

            <h5>😐 Neutral</h5>

            <h2>{{ $neutral }}</h2>

        </div>

    </div>



    <div class="col-md-4">

        <div class="card-box text-center">

            <h5>☹ Negative</h5>

            <h2>{{ $negative }}</h2>

        </div>

    </div>

</div>



<div class="row mt-4">

    <div class="col-md-12">

        <div class="card-box">

            <h5>

                Latest Supply Chain News

            </h5>

            <hr>

            @forelse($news as $item)

                <div class="row mb-4">

                    @if($item->image)

                    <div class="col-md-3">

                        <img

                            src="{{ $item->image }}"

                            class="img-fluid rounded"

                        >

                    </div>

                    <div class="col-md-9">

                    @else

                    <div class="col-md-12">

                    @endif

                        <h5>

                            <a

                                href="{{ $item->url }}"

                                target="_blank"

                            >

                                {{ $item->title }}

                            </a>

                        </h5>

                        <p>

                            {{ $item->description }}

                        </p>

                        <small>

                            <b>

                                Source :

                            </b>

                            {{ $item->source }}

                            |

                            <b>

                                Sentiment :

                            </b>

                            {{ $item->sentiment }}

                            |

                            <b>

                                Score :

                            </b>

                            {{ $item->sentiment_score }}

                            <br>

                            {{ optional($item->published_at)->format('d M Y H:i') }}

                        </small>

                    </div>

                </div>

                <hr>

            @empty

                <p>

                    No News Available

                </p>

            @endforelse

            <div class="mt-3">

                {{ $news->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
