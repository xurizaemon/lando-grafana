# Grafana and Graphite in Lando

This environment demonstrates a LAMP stack with additional Grafana and Graphite services.

The LAMP appserver has Collectd installed and configured to capture some metrics from the appserver environment, Apache and MySQL.

This environment is for demonstration purposes only; the intended use is to refer to this when configuring a Lando project to add Grafana support.

## Requirements

- A functioning Lando environment

## Setup

1. Clone this repository
2. `lando start`
3. Configure Grafana
4. Test it out

### Configure Grafana

- Visit http://grafana.test.lndo.site/
- Log in with `admin`/`admin`
- Press "skip" to avoid changing password
- Connections > Data source > Add new data source
- Choose type "Graphite"
  - Name is "Lando Graphite"
  - Source URL is `http://graphite.test.lndo.site:80`
- Explore data > Select "graphite" source
- Try a query of `*.*.*` - you should get some stats

### This configuration

This setup includes examples for:

- `config/collectd/apache.conf` - Collectd will _read_ data from Apache's `server-status` endpoint (this depends on Apache configuration addition in `config/apache2/status.conf`).
- `config/collectd/graphite.conf` - Collectd will _write_ data to Graphite.
- `config/collectd/debug.conf` - Collectd will _write_ debug info (useful for configuring Collectd).
- `config/collectd/mysql.conf` - Collectd will _read_ MySQL performance and stats from the `database` service.
- `config/collectd/nginx.conf` - TBC
- `config/collectd/os.conf` - Collectd will _read_ OS metrics.

### Test it out

Most likely this is useful if you copy the configuration here into an existing application to test.

If you're testing with this repo "as-is", you might like to modify `index.php` so that it generates errors occasionally, or test the `database.php` script. You can send lots of requests to the server by using a tool such as `ab` (from the `apache2-utils` package):

```bash
$ ab -n 1000 -c 25 https://test.lndo.site/database.php
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking test.lndo.site (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests

Server Software:        Apache/2.4.54
Server Hostname:        test.lndo.site
Server Port:            443
SSL/TLS Protocol:       TLSv1.2,ECDHE-RSA-AES256-GCM-SHA384,2048,256
Server Temp Key:        X25519 253 bits
TLS Server Name:        test.lndo.site

Document Path:          /database.php
Document Length:        83 bytes

Concurrency Level:      25
Time taken for tests:   21.760 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      280000 bytes
HTML transferred:       83000 bytes
Requests per second:    45.96 [#/sec] (mean)
Time per request:       544.000 [ms] (mean)
Time per request:       21.760 [ms] (mean, across all concurrent requests)
Transfer rate:          12.57 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        3    7   4.1      5      30
Processing:    89  529 502.0    358    4050
Waiting:       87  529 502.0    358    4049
Total:         92  536 503.3    363    4076

Percentage of the requests served within a certain time (ms)
  50%    363
  66%    511
  75%    664
  80%    754
  90%   1056
  95%   1391
  98%   1987
  99%   2754
 100%   4076 (longest request)
```
