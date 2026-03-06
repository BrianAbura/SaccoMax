@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Balance Sheet</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Balance Sheet </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>Balance Sheet Report</h5>
                            <p class="text-muted mb-3">Period: {{ date('F d, Y', strtotime($from)) }} to
                                {{ date('F d, Y', strtotime($to)) }}</p>

                            <form method="GET" action="{{ route('staff.balance-sheet', $period) }}"
                                class="row align-items-center g-3">
                                @csrf
                                <div class="col-md-3">
                                    <label for="from" class="form-label">From</label>
                                    <input type="date" name="from" id="from" class="form-control"
                                        value="{{ $from }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="to" class="form-label">To</label>
                                    <input type="date" name="to" id="to" class="form-control"
                                        value="{{ $to }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-end m-2">
                            <div class="dropdown">
                                <button class="btn btn-info btn-xs w-100 text-white dropdown-toggle" type="button"
                                    id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-download"></i> Export &nbsp;&nbsp;&nbsp;</button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li><a class="dropdown-item" href="#" onclick="exportToPDF()">Export as PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="exportToExcel()">Export as
                                            Excel</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="table table-bordered basic-1" id="balanceSheetTable">
                                    <thead>
                                        <tr>
                                            <th width="50%">Description</th>
                                            <th width="25%" class="text-end">Amount (UGX)</th>
                                            <th width="25%" class="text-end">Total (UGX)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- ASSETS SECTION -->
                                        <tr class="table-primary">
                                            <td colspan="3"><strong>ASSETS</strong></td>
                                        </tr>
                                        @forelse($assets as $assetGroup)
                                            <tr class="table-light">
                                                <td colspan="3"><strong>{{ $assetGroup['sub_category'] }}</strong></td>
                                            </tr>
                                            @foreach ($assetGroup['items'] as $item)
                                                <tr>
                                                    <td class="ps-4">{{ $item->item_name }}</td>
                                                    <td class="text-end">{{ number_format($item->item_value, 2) }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr class="table-light">
                                                <td class="ps-4"><strong>Total {{ $assetGroup['sub_category'] }}</strong>
                                                </td>
                                                <td></td>
                                                <td class="text-end">
                                                    <strong>{{ number_format($assetGroup['total'], 2) }}</strong>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No asset entries found for
                                                    this period</td>
                                            </tr>
                                        @endforelse
                                        <tr class="table-success">
                                            <td colspan="2"><strong>TOTAL ASSETS</strong></td>
                                            <td class="text-end"><strong>{{ number_format($totalAssets, 2) }}</strong></td>
                                        </tr>

                                        <!-- LIABILITIES SECTION -->
                                        <tr class="table-warning">
                                            <td colspan="3"><strong>LIABILITIES</strong></td>
                                        </tr>
                                        @forelse($liabilities as $liabilityGroup)
                                            <tr class="table-light">
                                                <td colspan="3"><strong>{{ $liabilityGroup['sub_category'] }}</strong>
                                                </td>
                                            </tr>
                                            @foreach ($liabilityGroup['items'] as $item)
                                                <tr>
                                                    <td class="ps-4">{{ $item->item_name }}</td>
                                                    <td class="text-end">{{ number_format($item->item_value, 2) }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            {{-- Add Members Savings line item if this is Current Liabilities --}}
                                            @if ($liabilityGroup['members_net_savings'] > 0)
                                                <tr>
                                                    <td class="ps-4">Members Net Savings</td>
                                                    <td class="text-end">
                                                        {{ number_format($liabilityGroup['members_net_savings'], 2) }}</td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                            <tr class="table-light">
                                                <td class="ps-4"><strong>Total
                                                        {{ $liabilityGroup['sub_category'] }}</strong></td>
                                                <td></td>
                                                <td class="text-end">
                                                    <strong>{{ number_format($liabilityGroup['total'], 2) }}</strong>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No liability entries found
                                                    for this period</td>
                                            </tr>
                                        @endforelse
                                        <tr class="table-success">
                                            <td colspan="2"><strong>TOTAL LIABILITIES</strong></td>
                                            <td class="text-end"><strong>{{ number_format($totalLiabilities, 2) }}</strong>
                                            </td>
                                        </tr>

                                        <!-- EQUITY SECTION -->
                                        <tr class="table-info">
                                            <td colspan="3"><strong>EQUITY</strong></td>
                                        </tr>
                                        @forelse($equity as $equityGroup)
                                            @if (isset($equityGroup['is_retained_earnings']) && $equityGroup['is_retained_earnings'])
                                                {{-- Display Retained Earnings as a single line item --}}
                                                <tr>
                                                    <td>Retained Earnings (Income - Expenses)</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($equityGroup['total'], 2) }}
                                                    </td>
                                                </tr>
                                            @elseif (isset($equityGroup['is_share_capital']) && $equityGroup['is_share_capital'])
                                                {{-- Display Share Capital as a single line item --}}
                                                <tr>
                                                    <td>Share Capital</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($equityGroup['total'], 2) }}
                                                    </td>
                                                </tr>
                                            @elseif (isset($equityGroup['is_membership_and_annual_fees']) && $equityGroup['is_membership_and_annual_fees'])
                                                {{-- Display Membership and Annual Fees as a single line item --}}
                                                <tr>
                                                    <td>Membership and Annual Fees</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($equityGroup['total'], 2) }}
                                                    </td>
                                                </tr>
                                            @else
                                                {{-- Display regular equity sub-categories --}}
                                                <tr class="table-light">
                                                    <td colspan="3"><strong>{{ $equityGroup['sub_category'] }}</strong>
                                                    </td>
                                                </tr>
                                                @foreach ($equityGroup['items'] as $item)
                                                    <tr>
                                                        <td class="ps-4">{{ $item->item_name }}</td>
                                                        <td class="text-end">{{ number_format($item->item_value, 2) }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                <tr class="table-light">
                                                    <td class="ps-4"><strong>Total
                                                            {{ $equityGroup['sub_category'] }}</strong></td>
                                                    <td></td>
                                                    <td class="text-end">
                                                        <strong>{{ number_format($equityGroup['total'], 2) }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No equity entries found
                                                    for this period</td>
                                            </tr>
                                        @endforelse
                                        <tr class="table-success">
                                            <td colspan="2"><strong>TOTAL EQUITY</strong></td>
                                            <td class="text-end"><strong>{{ number_format($totalEquity, 2) }}</strong>
                                            </td>
                                        </tr>

                                        <!-- GRAND TOTALS -->
                                        <tr class="table-dark">
                                            <td colspan="2" class="text-white"><strong>TOTAL LIABILITIES &
                                                    EQUITY</strong></td>
                                            <td class="text-end text-white">
                                                <strong>{{ number_format($totalLiabilities + $totalEquity, 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Balance Check Alert -->
                                @php
                                    $difference = $totalAssets - ($totalLiabilities + $totalEquity);
                                @endphp

                                @if (abs($difference) > 0.01)
                                    <div class="badge badge-danger mt-3">
                                        <strong>Balance Sheet Imbalance:</strong>
                                        Assets ({{ number_format($totalAssets, 2) }}) do not equal Liabilities + Equity
                                        ({{ number_format($totalLiabilities + $totalEquity, 2) }}).
                                        Difference: {{ number_format(abs($difference), 2) }}
                                    </div>
                                @else
                                    <div class="badge badge-success mt-3">
                                        <strong>Balance Sheet Balanced:</strong>
                                        Assets equal Liabilities + Equity ({{ number_format($totalAssets, 2) }})
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        const reportTitle = 'Balance Sheet';
        const reportPeriod = '{{ date('F d, Y', strtotime($from)) }} to {{ date('F d, Y', strtotime($to)) }}';

        async function exportToPDF() {
            // Create a temporary div for PDF content
            const tempDiv = document.createElement('div');
            tempDiv.className = 'pdf-export';
            tempDiv.style.padding = '40px';
            tempDiv.style.background = '#ffffff';
            tempDiv.style.width = '800px';
            document.body.appendChild(tempDiv);

            // Add header with logo
            const headerDiv = document.createElement('div');
            headerDiv.className = 'pdf-header';
            headerDiv.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="{{ asset('assets/images/logo/upplogo-nobg.png') }}" style="height: 80px; margin-bottom: 15px;">
                    <h1 style="color: #2c3e50; margin: 10px 0; font-size: 28px; font-weight: bold;">UPP SACCO</h1>
                    <h2 style="color: #34495e; margin: 10px 0; font-size: 24px;">${reportTitle}</h2>
                    <p style="color: #7f8c8d; font-size: 14px;">Period: ${reportPeriod}</p>
                    <p style="color: #7f8c8d; font-size: 12px;">Generated on ${new Date().toLocaleString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                    <hr style="border-top: 2px solid #eee; margin: 20px 0;">
                </div>
            `;
            tempDiv.appendChild(headerDiv);

            // Add table with enhanced styling
            const tableDiv = document.createElement('div');
            tableDiv.style.marginTop = '30px';
            const originalTable = document.querySelector('#balanceSheetTable');
            const cleanTable = document.createElement('table');
            cleanTable.style.width = '100%';
            cleanTable.style.borderCollapse = 'collapse';
            cleanTable.style.marginBottom = '20px';
            cleanTable.style.fontSize = '12px';

            // Copy and enhance table content
            const headerRow = originalTable.querySelector('thead').cloneNode(true);
            const dataRows = originalTable.querySelector('tbody').cloneNode(true);
            cleanTable.appendChild(headerRow);
            cleanTable.appendChild(dataRows);
            tableDiv.appendChild(cleanTable);
            tempDiv.appendChild(tableDiv);

            // Add balance status
            const balanceAlert = document.querySelector('.alert');
            if (balanceAlert) {
                const alertClone = balanceAlert.cloneNode(true);
                alertClone.style.marginTop = '20px';
                alertClone.style.padding = '15px';
                alertClone.style.borderRadius = '5px';
                tempDiv.appendChild(alertClone);
            }

            // Add enhanced CSS for PDF
            const style = document.createElement('style');
            style.textContent = `
                .pdf-export {
                    font-family: 'Arial', sans-serif;
                    color: #333;
                    line-height: 1.6;
                }
                .pdf-export table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    background: #fff;
                }
                .pdf-export th {
                    background: #e9ecef;
                    color: #2c3e50;
                    font-weight: bold;
                    padding: 12px 8px;
                    border: 1px solid #dee2e6;
                    text-align: left;
                    font-size: 12px;
                }
                .pdf-export td {
                    padding: 8px;
                    border: 1px solid #dee2e6;
                    color: #2d3436;
                    font-size: 11px;
                }
                .pdf-export .table-primary td {
                    background: #cfe2ff;
                    font-weight: bold;
                }
                .pdf-export .table-warning td {
                    background: #fff3cd;
                    font-weight: bold;
                }
                .pdf-export .table-info td {
                    background: #cff4fc;
                    font-weight: bold;
                }
                .pdf-export .table-success td {
                    background: #d1e7dd;
                    font-weight: bold;
                }
                .pdf-export .table-dark td {
                    background: #343a40;
                    color: #fff;
                    font-weight: bold;
                }
                .pdf-export .table-light td {
                    background: #f8f9fa;
                }
                .pdf-export .text-end {
                    text-align: right;
                }
                .pdf-export .ps-4 {
                    padding-left: 20px;
                }
                .pdf-export .alert {
                    padding: 15px;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .pdf-export .alert-success {
                    background: #d1e7dd;
                    border: 1px solid #badbcc;
                    color: #0f5132;
                }
                .pdf-export .alert-warning {
                    background: #fff3cd;
                    border: 1px solid #ffecb5;
                    color: #664d03;
                }
            `;
            tempDiv.appendChild(style);

            // Generate high-quality PDF
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');

            // Capture with higher quality settings
            const canvas = await html2canvas(tempDiv, {
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff',
                imageTimeout: 0,
                removeContainer: true
            });

            const imgData = canvas.toDataURL('image/png', 1.0);
            const pdfWidth = doc.internal.pageSize.getWidth() - 40;
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
            const pageHeight = doc.internal.pageSize.getHeight() - 40;

            let heightLeft = pdfHeight;
            let position = 20;

            // Add first page
            doc.addImage(imgData, 'PNG', 20, position, pdfWidth, pdfHeight);
            heightLeft -= pageHeight;

            // Add additional pages if needed
            while (heightLeft > 0) {
                position = heightLeft - pdfHeight + 20;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 20, position, pdfWidth, pdfHeight);
                heightLeft -= pageHeight;
            }

            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(10);
                doc.setTextColor(128);
                doc.text(`Page ${i} of ${pageCount}`, doc.internal.pageSize.getWidth() - 80, doc.internal.pageSize
                    .getHeight() - 20);
            }

            doc.save(`UPP-SACCO-Balance-Sheet-${new Date().toISOString().split('T')[0]}.pdf`);

            // Clean up
            document.body.removeChild(tempDiv);
        }

        function exportToExcel() {
            // Create a new workbook
            const wb = XLSX.utils.book_new();

            // Get the table data
            const table = document.querySelector('#balanceSheetTable');

            // Convert table to worksheet
            const ws = XLSX.utils.table_to_sheet(table);

            // Add worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Balance Sheet');

            // Add metadata sheet
            const metadata = [
                ['UPP SACCO'],
                ['Balance Sheet Report'],
                ['Period:', reportPeriod],
                ['Generated:', new Date().toLocaleString()],
                [''],
            ];
            const metaWs = XLSX.utils.aoa_to_sheet(metadata);
            XLSX.utils.book_append_sheet(wb, metaWs, 'Report Info');

            // Save the file
            XLSX.writeFile(wb, `UPP-SACCO-Balance-Sheet-${new Date().toISOString().split('T')[0]}.xlsx`);
        }
    </script>
@endpush
