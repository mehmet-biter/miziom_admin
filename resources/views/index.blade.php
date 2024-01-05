<x-layout.default>
    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="sales">
        <div class="pt-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 text-white">
                <!-- Users Visit -->
                <div class="panel bg-gradient-to-r from-cyan-500 to-cyan-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-xl font-semibold">{{  __('Total User') }}</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="{{ route('userList') }}" @click="toggle">{{ __("Visit") }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> {{ isset($users) ? $users : 0 }} </div>
                    </div>
                </div>

                <!-- Sessions -->
                <div class="panel bg-gradient-to-r from-violet-500 to-violet-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-xl font-semibold">{{ __("Total Coin") }}</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">

                                <li><a href="{{ route("adminCoinList") }}" @click="toggle">{{ __("Visit") }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> {{ isset($coins) ? $coins : 0 }} </div>
                    </div>
                </div>

                <!-- Time On-Site -->
                <div class="panel bg-gradient-to-r from-blue-500 to-blue-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-xl font-semibold">{{ __("Total Deposit") }}</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="{{ route('adminActiveDeposit') }}" @click="toggle">{{ __('Visit') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> ${{ isset($deposit) ? $deposit : 0 }} </div>
                    </div>
                </div>

                <!-- Bounce Rate -->
                <div class="panel bg-gradient-to-r from-fuchsia-500 to-fuchsia-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-xl font-semibold">{{ __('Total Profit') }}</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="{{ route('adminActiveWithdrawal') }}" @click="toggle">{{ __('Visit') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> ${{ isset($profit) ? $profit : 0 }} </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="panel h-full">
                    <div class="mb-5 text-lg font-bold">{{ __("Recent Withdrawal") }}</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">{{ __('Type') }}</th>
                                    <th>{{ __('Coin') }}</th>
                                    <th>{{ _('Address') }}</th>
                                    <th>{{ __('Amont') }}</th>
                                    <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recent_withdrawal))
                                    @foreach ($recent_withdrawal as $w)
                                        <tr>
                                            <td class="font-semibold">{{ addressType($w->address_type) }}</td>
                                            <td class="whitespace-nowrap">{{ $w->coin_type }}</td>
                                            <td class="whitespace-nowrap">{{ $w->address }}</td>
                                            <td>{{ $w->amount }} {{ $w->coin_type }}</td>
                                            <td class="text-center"> {{ $w->created_at }} </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="panel h-full">
                    <div class="mb-5 text-lg font-bold">{{ __("Recent Deposit") }}</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">{{ __('Type') }}</th>
                                    <th>{{ __('Coin') }}</th>
                                    <th>{{ _('Address') }}</th>
                                    <th>{{ __('Amont') }}</th>
                                    <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recent_deposit))
                                    @foreach ($recent_deposit as $de)
                                        <tr>
                                            <td class="font-semibold">{{ addressType($de->address_type) }}</td>
                                            <td class="whitespace-nowrap">{{ $de->coin_type }}</td>
                                            <td class="whitespace-nowrap">{{ $de->address }}</td>
                                            <td>{{ $de->amount }} {{ $de->coin_type }}</td>
                                            <td class="text-center"> {{ $de->created_at }} </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            // finance
            Alpine.data("finance", () => ({
                init() {
                    const bitcoin = null;
                    const ethereum = null;
                    const litecoin = null;
                    const binance = null;
                    const tether = null;
                    const solana = null;

                    setTimeout(() => {
                        this.bitcoin = new ApexCharts(this.$refs.bitcoin, this.bitcoinOptions);
                        this.bitcoin.render();

                        this.ethereum = new ApexCharts(this.$refs.ethereum, this
                            .ethereumOptions);
                        this.ethereum.render();

                        this.litecoin = new ApexCharts(this.$refs.litecoin, this
                            .litecoinOptions);
                        this.litecoin.render();

                        this.binance = new ApexCharts(this.$refs.binance, this.binanceOptions);
                        this.binance.render();

                        this.tether = new ApexCharts(this.$refs.tether, this.tetherOptions);
                        this.tether.render();

                        this.solana = new ApexCharts(this.$refs.solana, this.solanaOptions);
                        this.solana.render();
                    }, 300);

                },

                get bitcoinOptions() {
                    return {
                        series: [{
                            data: [21, 9, 36, 12, 44, 25, 59, 41, 25, 66]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get ethereumOptions() {
                    return {
                        series: [{
                            data: [44, 25, 59, 41, 66, 25, 21, 9, 36, 12]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get litecoinOptions() {
                    return {
                        series: [{
                            data: [9, 21, 36, 12, 66, 25, 44, 25, 41, 59]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get binanceOptions() {
                    return {
                        series: [{
                            data: [25, 44, 25, 59, 41, 21, 36, 12, 19, 9]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get tetherOptions() {
                    return {
                        series: [{
                            data: [21, 59, 41, 44, 25, 66, 9, 36, 25, 12]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get solanaOptions() {
                    return {
                        series: [{
                            data: [21, -9, 36, -12, 44, 25, 59, -41, 66, -25]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                }
            }));
        });
    </script>

</x-layout.default>

