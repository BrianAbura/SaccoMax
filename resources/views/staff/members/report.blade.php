@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">{{ $title }} </li>
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

                            <form method="GET" action="{{ route('staff.members.report', request('report_type', $type)) }}"
                                class="row align-items-center g-3">
                                @csrf
                                <div class="col-md-3">
                                    <label for="from" class="form-label">From</label>
                                    <input type="date" name="from" id="from" class="form-control"
                                        value="{{ request('from') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="to" class="form-label">To</label>
                                    <input type="date" name="to" id="to" class="form-control"
                                        value="{{ request('to') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="report_type" class="form-label">Report Type</label>
                                    <select name="report_type" id="report_type" class="form-select">
                                        <option value="all"
                                            {{ request('report_type', $type) == 'all' ? 'selected' : '' }}>All Members
                                        </option>
                                        <option value="inactive"
                                            {{ request('report_type', $type) == 'inactive' ? 'selected' : '' }}>Inactive
                                            Members</option>
                                        <option value="savings"
                                            {{ request('report_type', $type) == 'savings' ? 'selected' : '' }}>
                                            Member Savings</option>
                                        <option value="withdrawals"
                                            {{ request('report_type', $type) == 'withdrawals' ? 'selected' : '' }}>
                                            Member Withdrawals</option>
                                    </select>
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
                            @if ($chartData)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            @php
                                                $reportType = request('report_type', $type);
                                            @endphp
                                            @if ($reportType == 'all')
                                                Monthly Member Registration Statistics
                                            @elseif ($reportType == 'savings')
                                                Member Savings Overview
                                            @elseif ($reportType == 'withdrawals')
                                                Member Withdrawals Overview
                                            @else
                                                Report Overview
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-{{ $reportType == 'all' ? '8' : '12' }}">
                                                <canvas id="membershipChart" style="width: 100%; height: 400px;"></canvas>
                                            </div>
                                            @if (request('report_type', $type) == 'all')
                                                <div class="col-md-4">
                                                    <div class="chart-legend" id="chartLegend"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1">
                                    <thead>
                                        <tr>
                                            @foreach ($headers as $header)
                                                <th class="px-4 py-2 bg-gray-100">{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $index => $row)
                                            <tr>
                                                @foreach ($row as $cell)
                                                    <td class="px-4 py-2">{{ $cell }}</td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ count($headers) }}" class="text-center py-4">No records
                                                    found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
        // Store the title from Blade variable
        const reportTitle = '{{ $title }}';

        document.addEventListener('DOMContentLoaded', function() {
            @if ($chartData)
                const ctx = document.getElementById('membershipChart').getContext('2d');
                const chartData = @json($chartData);

                // Generate random colors for each data point
                const colors = chartData.data.map(() => {
                    const r = Math.floor(Math.random() * 200);
                    const g = Math.floor(Math.random() * 200);
                    const b = Math.floor(Math.random() * 200);
                    return `rgb(${r}, ${g}, ${b})`;
                });

                const reportType = '{{ request('report_type', $type) }}';
                const isAllMembers = reportType === 'all';
                const isSavings = reportType === 'savings';
                const isWithdrawals = reportType === 'withdrawals';
                const isFinancialReport = isSavings || isWithdrawals;

                new Chart(ctx, {
                    type: isAllMembers ? 'pie' : 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            data: chartData.data,
                            backgroundColor: isAllMembers ? colors :
                                             isSavings ? '#22C55E' :
                                             isWithdrawals ? '#EE5757' : '#4e73df',
                            borderColor: isAllMembers ? colors :
                                         isSavings ? '#22C55E' :
                                         isWithdrawals ? '#EE5757' : '#4e73df',
                            borderWidth: 1,
                            label: isAllMembers ? undefined :
                                   isSavings ? 'Savings Amount (UGX)' :
                                   isWithdrawals ? 'Withdrawals Amount (UGX)' : ''
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: isAllMembers ? 'right' : 'top',
                                display: isAllMembers,
                                labels: isAllMembers ? {
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        if (data.labels.length && data.datasets.length) {
                                            return data.labels.map((label, i) => ({
                                                text: `${label}: ${data.datasets[0].data[i]} members`,
                                                fillStyle: data.datasets[0]
                                                    .backgroundColor[i],
                                                strokeStyle: data.datasets[0]
                                                    .backgroundColor[i],
                                                lineWidth: 0,
                                                hidden: false,
                                                index: i
                                            }));
                                        }
                                        return [];
                                    }
                                } : undefined
                            },
                            title: {
                                display: true,
                                text: isAllMembers ? 'Member Registrations by Month' :
                                      isSavings ? 'Member Savings Overview' :
                                      isWithdrawals ? 'Member Withdrawals Overview' :
                                      'Report Overview',
                                font: {
                                    size: 16
                                }
                            }
                        },
                        scales: isFinancialReport ? {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'UGX ' + value.toLocaleString();
                                    }
                                }
                            }
                        } : undefined
                    }
                });
            @endif
        });
    </script>

    <script>
        async function exportToPDF() {
            // Create a temporary div for PDF content
            const tempDiv = document.createElement('div');
            tempDiv.className = 'pdf-export';
            tempDiv.style.padding = '40px';
            tempDiv.style.background = '#ffffff';
            document.body.appendChild(tempDiv);

            // Add header with logo
            const headerDiv = document.createElement('div');
            headerDiv.className = 'pdf-header';
            headerDiv.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="{{ asset('assets/images/logo/saccomax_logo.png') }}" style="height: 80px; margin-bottom: 15px;">
                    <h2 style="color: #34495e; margin: 10px 0; font-size: 24px;">${reportTitle}</h2>
                    <p style="color: #7f8c8d; font-size: 14px;">Generated on ${new Date().toLocaleString('en-US', {
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

            // Add chart if it exists with enhanced styling
            if (document.getElementById('membershipChart')) {
                const chartDiv = document.createElement('div');
                chartDiv.style.marginBottom = '30px';
                chartDiv.style.padding = '20px';
                chartDiv.style.background = '#fff';
                chartDiv.style.borderRadius = '8px';
                chartDiv.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                chartDiv.style.height = '400px';
                tempDiv.appendChild(chartDiv);

                // Add chart title
                const chartTitle = document.createElement('h3');
                chartTitle.style.color = '#2c3e50';
                chartTitle.style.fontSize = '18px';
                chartTitle.style.marginBottom = '15px';
                chartTitle.style.textAlign = 'center';
                chartTitle.textContent = '{{ $type }}' === 'all' ?
                    'Monthly Member Registration Statistics' : 'Member Savings Overview';
                chartDiv.appendChild(chartTitle);

                // Clone and enhance the chart
                const originalCanvas = document.getElementById('membershipChart');
                const chartCanvas = originalCanvas.cloneNode(true);
                chartCanvas.style.width = '100%';
                chartCanvas.style.height = '350px';
                chartDiv.appendChild(chartCanvas);

                // Copy the chart with enhanced styling
                const originalChart = Chart.getChart(originalCanvas);
                new Chart(chartCanvas, {
                    type: originalChart.config.type,
                    data: originalChart.config.data,
                    options: {
                        ...originalChart.config.options,
                        animation: false,
                        plugins: {
                            ...originalChart.config.options.plugins,
                            legend: {
                                ...originalChart.config.options.plugins.legend,
                                labels: {
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: '#f0f0f0'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f0f0f0'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Add table with enhanced styling
            const tableDiv = document.createElement('div');
            tableDiv.style.marginTop = '30px';
            const originalTable = document.querySelector('.basic-1');
            const cleanTable = document.createElement('table');
            cleanTable.style.width = '100%';
            cleanTable.style.borderCollapse = 'collapse';
            cleanTable.style.marginBottom = '20px';
            cleanTable.style.fontSize = '14px';

            // Copy and enhance table content
            const headerRow = originalTable.querySelector('thead').cloneNode(true);
            const dataRows = originalTable.querySelector('tbody').cloneNode(true);
            cleanTable.appendChild(headerRow);
            cleanTable.appendChild(dataRows);
            tableDiv.appendChild(cleanTable);
            tempDiv.appendChild(tableDiv);

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
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                }
                .pdf-export th {
                    background: #f8f9fa;
                    color: #2c3e50;
                    font-weight: bold;
                    padding: 12px;
                    border: 1px solid #dee2e6;
                    text-align: left;
                    font-size: 14px;
                }
                .pdf-export td {
                    padding: 10px;
                    border: 1px solid #dee2e6;
                    color: #2d3436;
                    font-size: 13px;
                }
                .pdf-export tr:nth-child(even) {
                    background: #f8f9fa;
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

            doc.addImage(imgData, 'PNG', 20, 20, pdfWidth, pdfHeight);

            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(10);
                doc.setTextColor(128);
                doc.text(`Page ${i} of ${pageCount}`, doc.internal.pageSize.getWidth() - 60, doc.internal.pageSize
                    .getHeight() - 30);
            }

            doc.save(`SACCOMAX-${reportTitle}-${new Date().toISOString().split('T')[0]}.pdf`);

            // Clean up
            document.body.removeChild(tempDiv);
        }

        function exportToExcel() {
            const table = document.querySelector('.basic-1');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: reportTitle
            });
            XLSX.writeFile(wb, `SACCOMAX-${reportTitle}-${new Date().toISOString().split('T')[0]}.xlsx`);
        }
    </script>
@endpush
