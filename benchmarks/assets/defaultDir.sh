#!/bin/bash

defaultDir() {
	# Create default directories for benchmark
	if ! [[ -d "${default_directory}" ]]; then
		mkdir -p "${default_directory}"
		printf "%s\n" "${delimiter}"
		printf "| [+] Directory %s created\n" "${default_directory}"
		printf "%s\n" "${delimiter}"
	else
		printf "%s\n" "${delimiter}"
		printf "| [+] Directory %s exists\n" "${default_directory}"
		printf "%s\n" "${delimiter}"
	fi

	if ! [[ -d "${default_directory}/data/" ]]; then
		mkdir -p "${default_directory}/data/"
		printf "%s\n" "${delimiter}"
		printf "| [+] Directory %s/data/ created\n" "${default_directory}"
		printf "%s\n" "${delimiter}"
	else
		printf "%s\n" "${delimiter}"
		printf "| [+] Directory %s/data/ exists\n" "${default_directory}"
		printf "%s\n" "${delimiter}"
	fi

	# Change to default directory
	cd "${default_directory}"
}
