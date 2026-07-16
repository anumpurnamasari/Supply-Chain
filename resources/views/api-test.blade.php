@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">
            🔧 API Test Center
        </h2>

        <p class="text-muted">
            ChainPulse External API Monitoring
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                External API Status
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="40">
                            No
                        </th>

                        <th>
                            API
                        </th>

                        <th>
                            Description
                        </th>

                        <th width="150">
                            Test
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>

                            <strong>
                                REST Countries
                            </strong>

                        </td>

                        <td>

                            Country Information

                        </td>

                        <td>

                            <a href="/api-test/countries"
                               target="_blank"
                               class="btn btn-success btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>





                    <tr>

                        <td>2</td>

                        <td>

                            <strong>
                                Open Meteo
                            </strong>

                        </td>

                        <td>

                            Weather Monitoring

                        </td>

                        <td>

                            <a href="/api-test/weather"
                               target="_blank"
                               class="btn btn-primary btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>





                    <tr>

                        <td>3</td>

                        <td>

                            <strong>
                                World Bank
                            </strong>

                        </td>

                        <td>

                            GDP, Inflation, Population,
                            Export & Import

                        </td>

                        <td>

                            <a href="/api-test/economic"
                               target="_blank"
                               class="btn btn-warning btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>






                    <tr>

                        <td>4</td>

                        <td>

                            <strong>
                                Exchange Rate
                            </strong>

                        </td>

                        <td>

                            Currency Exchange

                        </td>

                        <td>

                            <a href="/api-test/currency"
                               target="_blank"
                               class="btn btn-info btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>






                    <tr>

                        <td>5</td>

                        <td>

                            <strong>
                                GNews
                            </strong>

                        </td>

                        <td>

                            Logistics & Economy News

                        </td>

                        <td>

                            <a href="/api-test/news"
                               target="_blank"
                               class="btn btn-danger btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>






                    <tr>

                        <td>6</td>

                        <td>

                            <strong>
                                OpenStreetMap
                            </strong>

                        </td>

                        <td>

                            Port Monitoring

                        </td>

                        <td>

                            <a href="/api-test/ports"
                               target="_blank"
                               class="btn btn-secondary btn-sm">

                                Test API

                            </a>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
