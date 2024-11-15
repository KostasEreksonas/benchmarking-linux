#!/bin/bash

showProgress() {
	# Show progress of a benchmark iteration

	# Get local variables
	local tmp_file="${1}"

	# Get last line of tmp file
    line="$(sed 's/\r/\n/g' "${tmp_file}" | tail -1)"

	# Update text
    text="$(echo "${line}" | awk '{print "| [+] " $0}')"

	# Print newline at the end of an encode
	printf "%s" "${text}"

}
