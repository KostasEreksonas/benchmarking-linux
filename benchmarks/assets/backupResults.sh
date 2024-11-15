#!/bin/bash

backupResults() {
	# Backup previous results file before a new benchmark run
	if [[ -f "${result_file}" ]]; then
		result_file_count=$(find . -type f -name "results*" | wc -l)
		mv "${result_file}" "${result_file%.*}_${result_file_count}.${result_file#*.}"
	fi
}
