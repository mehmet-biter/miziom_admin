<?php

function edit_html($route, $id)
{
    $html = '<a href="' . route($route, $id) . '"  title="'.__('Edit').'" class="hover:text-info">';
    $html .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">';
    $html .= '<path opacity="0.5" d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" ></path>';
    $html .= '<path d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"';
    $html .= 'stroke="currentColor" stroke-width="1.5"></path>';
    $html .= '    <path opacity="0.5"';
    $html .= '        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"';
    $html .= '       stroke="currentColor" stroke-width="1.5"> </path> </svg> </a>';
    return $html;
}

function view_html($route, $id)
{
    $html = '<a href="'.route($route,$id).'" class="hover:text-primary">';
    $html .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">';
    $html .= '<path  opacity="0.5"';
    $html .= 'd="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"';
    $html .= 'stroke="currentColor"  stroke-width="1.5"></path>';
    $html .= '<path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>';
    $html .= '</svg> </a>';
    return $html;
}

function delete_html($route, $id)
{
    $html = '<a href="'.route($route,$id).'" class="hover:text-primary">';
    $html .= '<button type="button" class="hover:text-danger">';
    $html .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">';
    $html .= '<path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>';
    $html .= '<path d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"';
    $html .= 'stroke="currentColor"  stroke-width="1.5" stroke-linecap="round"></path>';
    $html .= '<path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>';
    $html .= '<path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>';
    $html .= '<path opacity="0.5" d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"';
    $html .= 'stroke="currentColor" stroke-width="1.5"> </path>';
    $html .= '</svg> </button>';
    $html .= '</a>';
    return $html;
}

function print_html($route, $id)
{
    $html = '<a href="'.route($route,$id).'" class="hover:text-primary">';
    $html .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">';
    $html .= '<path d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827" stroke="currentColor" stroke-width="1.5" />';
    $html .= '<path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />';
    $html .= '<path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />';
    $html .= '<path d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /> ';
    $html .= '<path opacity="0.5"   d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6" ';
    $html .= 'stroke="currentColor" stroke-width="1.5" /> <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />';
    $html .= '<path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />';
    $html .= '<path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />';
    $html .= '</svg> </a>';
    return $html;
}

function imageWithName($name,$path,$img) {
    $imgPath = imageSrcUser($path,$img);
    
    $html = '<div class="flex items-center font-semibold"><div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">';
    $html .= '<img class="h-8 w-8 rounded-full object-cover" src="'.$imgPath.'" /></div>';
    $html .= '<span>'.$name.'</span></div>';
    return $html;
}

function status($input = null)
{
    $output = [
        STATUS_ACTIVE => '<span class="inline-block px-2 py-1 text-sm font-semibold leading-none text-green-600 bg-green-100 rounded-full">'.__('Active'). '</span>',
        STATUS_DEACTIVE => '<span class="inline-block px-2 py-1 text-sm font-semibold leading-none text-red-600 bg-green-100 rounded-full">'.__('Deactive').'</span>',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}