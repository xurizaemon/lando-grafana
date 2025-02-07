# Grafana and Graphite in Lando

This environment demonstrates a LAMP stack with additional observability services.

- The default Lando appserver has Collectd installed and configured to capture some metrics from the appserver environment, Apache and MySQL.
- Alloy https://grafana.com/docs/alloy/latest/
- Graphite 
- Loki
- Mimir
- Tempo
- Grafana

## Usage

- Bring this environment up.
- Configure observability reporting on other local Lando projects
- Observe & interact

## Requirements

- Lando, Docker

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

Most likely this is useful if you set up OTel reporting in an adjacent environment and use this project to observe that project.

This project contains an appserver service which is configured to gather metrics and observability data also. 

An example `index.php` and `database.php` are provided to generate some activity which can be observed.

```bash
$ ab -n 1000 -c 25 https://o11y.lndo.site/database.php
```
