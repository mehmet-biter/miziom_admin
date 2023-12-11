<x-layout.default>


    <div x-data="invoicePreview">
        <div class="flex items-center lg:justify-end justify-center flex-wrap gap-4 mb-6">
            
            <button type="button" class="btn btn-primary gap-2" @click="print">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5">
                    <path
                        d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
                        stroke="currentColor" stroke-width="1.5" />
                    <path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path opacity="0.5"
                        d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
                        stroke="currentColor" stroke-width="1.5" />
                    <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
                    <path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                </svg>
                Print </button>

            <a href="{{ route('alumniStudentEdit',$item->unique_code) }}" class="btn btn-warning gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                    <path opacity="0.5"
                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    <path
                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                        stroke="currentColor" stroke-width="1.5"></path>
                    <path opacity="0.5"
                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                        stroke="currentColor" stroke-width="1.5"></path>
                </svg>
                Edit </a>
        </div>
        <div class="panel">
            <div class="flex justify-between flex-wrap gap-4 px-4">
                <div class="text-2xl font-semibold uppercase">Student Preview</div>
            </div>

            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
            <div id="printDiv" class="flex justify-between lg:flex-row flex-col gap-6 flex-wrap">
                @include('alumni.student.include.print')
            </div>
           
        </div>
    </div>
    <style>
        /* Style for :before and :after pseudo-elements */
        #emailContainer::before,
        #emailContainer::after {
            border-style: none !important;
        }
    </style>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('invoicePreview', () => ({
                

                print() {
                    var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
                    var footer_str = '</body></html>';
                    var new_str = document.getElementById('printDiv').innerHTML;
                    var old_str = document.body.innerHTML;
                    document.body.innerHTML = header_str + new_str + footer_str;
                    window.print();
                    document.body.innerHTML = old_str;
                    return false;
                }
                
            }));
        });
    </script>
</x-layout.default>
