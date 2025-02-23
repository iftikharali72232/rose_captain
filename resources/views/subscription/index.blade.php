@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>




            <div class="max-w-4xl mx-auto bg-white p-4 rounded-2 shadow-sm">
                <h2 class="fw-bold mb-6">{{ trans('lang.subscription') }}</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>

                            <th>{{ trans('lang.driver_name') }}</th>
                            <th>{{ trans('lang.booking_type') }}</th>
                            <th>{{ trans('lang.from_date') }}</th>
                            <th>{{ trans('lang.to_date') }}</th>
                            <th>{{ trans('lang.amount') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscription as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $data->user->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($data->subscription_type) }}</td>
                                <td>{{ date('d-m-Y',strtotime($data->from_date)) }}</td>
                                <td>{{ date('d-m-Y',strtotime($data->to_date)) }}</td>
                                <td>{{ number_format($data->amount,2)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>






    <script>
        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const table = document.getElementById("pdfTable");

            // Convert HTML table to canvas
            html2canvas(table).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const imgWidth = 190; // Adjust width
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
                doc.save("passenger_list.pdf");
            });
        }
    </script>
@endsection
