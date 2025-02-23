@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>




            <div class="max-w-4xl mx-auto bg-white p-4 rounded-2 shadow-sm">
                <h2 class="fw-bold mb-6">{{ trans('lang.customer') }}</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>

                            <th>{{ trans('lang.name') }}</th>
                            <th>{{ trans('lang.mobile') }}</th>
                            <th>{{ trans('lang.city') }}</th>
                            <th>{{ trans('lang.gender') }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customer as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $data->name ?? 'N/A' }}</td>
                                <td>{{ $data->mobile }}</td>
                                <td>{{ $data->city }}</td>
                                <td>{{ ($data->gender  == 1) ? 'Male' : 'Female' }}</td>

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
