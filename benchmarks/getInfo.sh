#!/bin/bash

#  ---------
# | Sources |
#  ---------
source formatTime.sh

getInfo() {
    # Get system info
	arch="$(uname -m)"
    os="$(grep -w ID /etc/os-release | cut -d "=" -f 2)"
	os="$(echo "${os}" | sed 's/\"//g')"
	cpu="$(lscpu | grep "Model name" | cut -d ":" -f 2 | xargs)"
    cores="$(grep "cpu cores" /proc/cpuinfo | head -1 | cut -d ":" -f 2 | tr -d " ")"
    threads="$(grep -c processor /proc/cpuinfo)"
    min_freq="$(echo "$(lscpu | grep "CPU min" | cut -d ":" -f 2 | cut -d "." -f 1 | tr -d " ")/1000" | bc -l 2>/dev/null)"
    max_freq="$(echo "$(lscpu | grep "CPU max" | cut -d ":" -f 2 | cut -d "." -f 1 | tr -d " ")/1000" | bc -l 2>/dev/null)"
    memory="$(echo "$(grep MemTotal /proc/meminfo | cut -d ":" -f 2 | tr -d " kB")/1024/1024" | bc -l 2>/dev/null)"
    uptime="$(formatTime "$(cut -d " " -f 1 < /proc/uptime)")"
    gpu=$(lspci | grep -E 'VGA|3D')
	gpu="${gpu//$'\n'/ }"
	gpu="${gpu#*[}"
	gpu="${gpu%]*}"

	# Print system info to screen
    printf "%s\n" "${delimiter}"
    printf "| [+] System info\n"
    printf "%s\n" "${delimiter}"
	printf "| [+] Architecture: %s\n" "${arch}"
    printf "| [+] OS: %s\n" "${os}"
    printf "| [+] CPU: %s\n" "${cpu}"
    printf "| [+] Cores: %s\n" "${cores}"
    printf "| [+] Threads: %s\n" "${threads}"
    printf "| [+] Min frequency: %0.2f GHz\n" "${min_freq:-NaN}"
	printf "| [+] Max frequency: %0.2f GHz\n" "${max_freq:-NaN}"
    printf "| [+] Memory: %.2f GB\n" "${memory:-NaN}"
    printf "| [+] Uptime: %s\n" "${uptime}"
	printf "| [+] GPU: %s\n" "${gpu}"
    printf "%s\n" "${delimiter}"

	# Write system info to file
	{
		printf "%s\n" "${delimiter}";
		printf "| [+] System info\n";
		printf "%s\n" "${delimiter}";
		printf "| [+] Architecture: %s\n" "${arch}";
		printf "| [+] OS: %s\n" "${os}";
		printf "| [+] CPU: %s\n" "${cpu}";
		printf "| [+] Cores: %s\n" "${cores}";
		printf "| [+] Threads: %s\n" "${threads}";
		printf "| [+] Min frequency: %0.2f GHz\n" "${min_freq:-NaN}";
		printf "| [+] Max frequency: %0.2f GHz\n" "${max_freq:-NaN}";
		printf "| [+] Memory: %.2f GB\n" "${memory:-NaN}";
		printf "| [+] Uptime: %s\n" "${uptime}";
		printf "| [+] GPU: %s\n" "${gpu}";
		printf "%s\n" "${delimiter}";
	} >> "${result_file}"
}
