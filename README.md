## Setup

## Configure Grafana

- Visit http://grafana.test.lndo.site/
- Log in with `admin`/`admin`
- Connections > Data source > Add new data source
- Type "Graphite" with source URL `http://graphite.test.lndo.site:80`
- Explore data > Select "graphite" source
- Try a query of `*.*.*` - you should get some stats
