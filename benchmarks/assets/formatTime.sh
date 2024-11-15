#!/bin/bash

formatTime() {
    # Format time to <xx>h <xx>m <xx.xxx>s
    time="${1}"

	# Get seconds value
    seconds="${time%%.*}"
    if [[ -z "${seconds}" ]]; then seconds=0; fi
    miliseconds="${time##*.}"
    if [[ -z "${miliseconds}" ]]; then miliseconds=0; fi
	if [[ "${seconds}" -lt 60 ]]; then
        printf "%s.%s seconds\n" "${seconds}" "${miliseconds}"
    elif [[ "${seconds}" -ge 60 && "${seconds}" -lt 3600 ]]; then
        minutes="$(echo "${seconds}/60" | bc -l | cut -d "." -f 1)"
        if [[ -z "${minutes}" ]]; then minutes=0; fi
		seconds="$((${seconds}-60*${minutes}))"
        if [[ -z "${seconds}" ]]; then seconds=0; fi
		if [[ "${minutes}" == 1 ]]; then
			printf "%s minute %s.%s seconds\n" "${minutes}" "${seconds}" "${miliseconds}"
		else
			printf "%s minutes %s.%s seconds\n" "${minutes}" "${seconds}" "${miliseconds}"
		fi
	elif [[ "${seconds}" -ge 3600 ]]; then
        hours="$(echo "${seconds}/3600" | bc -l | cut -d "." -f 1)"
        if [[ -z "${hours}" ]]; then hours=0; fi
        seconds="$((${seconds}-3600*${hours}))"
        minutes="$(echo "${seconds}/60" | bc -l | cut -d "." -f 1)"
        if [[ -z "${minutes}" ]]; then minutes=0; fi
        seconds="$((${seconds}-60*${minutes}))"
        if [[ -z "${seconds}" ]]; then seconds=0; fi
		if [[ "${hours}" == 1 ]] && [[ "${minutes}" == 1 ]]; then
			printf "%s hour %s minute %s.%s seconds\n" "${hours}" "${minutes}" "${seconds}" "${miliseconds}"
		elif [[ "${hours}" == 1 ]] && [[ "${minutes}" -gt 1 ]]; then
			printf "%s hour %s minutes %s.%s seconds\n" "${hours}" "${minutes}" "${seconds}" "${miliseconds}"
		elif [[ "${hours}" -gt 1 ]] && [[ "${minutes}" == 1 ]]; then
			printf "%s hours %s minute %s.%s seconds\n" "${hours}" "${minutes}" "${seconds}" "${miliseconds}"
		else
			printf "%s hours %s minutes %s.%s seconds\n" "${hours}" "${minutes}" "${seconds}" "${miliseconds}"
		fi
	fi
}
