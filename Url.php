<?php

class Url
{
    public $link;
    private $langugae = 0;

    public function __construct($_get_url = null)
    {
        if ($_get_url === null) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $this->link = "https";
            else
                $this->link = "http";
            $this->link .= "://";
            $this->link .= $_SERVER['HTTP_HOST'];
            $this->link .= $_SERVER['REQUEST_URI'];
        } else {
            $this->link = $_get_url;
        }
    }

    public function full()
    {
        return ($this->link);
    }

    public function user()
    {
        return (parse_url($this->link, PHP_URL_USER));
    }

    public function pass()
    {
        return (parse_url($this->link, PHP_URL_PASS));
    }

    public function base()
    {
        return ($this->protocol() . "://" . $this->sub_domain() . "." . $this->domain() . "." . $this->tld() . ":" . $this->port());
    }

    public function protocol()
    {
        return (parse_url($this->link, PHP_URL_SCHEME));
    }

    public function sub_domain()
    {
        $info = parse_url($this->link);
        $sub_domain = $info['host'];
        $sub_domain_names = explode(".", $sub_domain);

        return ($sub_domain_names[count($sub_domain_names) - 3]);
    }

    public function domain()
    {
        $info = parse_url($this->link);
        $domain = $info['host'];
        $domain_names = explode(".", $domain);

        return ($domain_names[count($domain_names) - 2] . "." . $this->tld());
    }

    public function root()
    {
        $info = parse_url($this->link);
        $root = $info['host'];
        $root_names = explode(".", $root);

        return ($root_names[count($root_names) - 2]);
    }

    public function tld()
    {
        $info = parse_url($this->link);
        $tld = $info['host'];
        $tld_names = explode(".", $tld);

        return ($tld_names[count($tld_names) - 1]);
    }

    public function port()
    {
        return (parse_url($this->link, PHP_URL_PORT));
    }

    public function lang()
    {
        $info = parse_url($this->link, PHP_URL_PATH);
        $path_parts = explode("/", $info);
        $arr = ["fa", "en", "ar", "zh", "nl", "fr", "hi", "it", "ja"];
        if (in_array($path_parts[1], $arr)) {
            $this->langugae++;
            return ($path_parts[1]);
        } else {
            return null;
        }
    }

    public function dir($_entery = null)
    {
        $info = parse_url($this->link, PHP_URL_PATH);
        $path_parts = explode("/", $info);

        if ($_entery === null) return $info;
        else return ($path_parts[$_entery + $this->langugae + 1]);
    }

    public function content()
    {
        if (null !== $this->dir(0)) return ($this->dir(0));
        else return null;
    }

    public function module()
    {
        if (null !== $this->dir(1)) return ($this->dir(1));
        else return null;
    }

    public function child()
    {
        if (null !== $this->dir(2)) return ($this->dir(2));
        else return null;
    }

    public function property($_entery = null)
    {
        $info = parse_url($this->link, PHP_URL_PATH);
        $path_parts = explode("/", $info);
        $full_property = "";
        for ($i = 4 + $this->langugae; $i < sizeof($path_parts); $i++) {
            $full_property .=  "/" . $path_parts[$i];
        }
        if ($_entery === null) return $full_property;
        else {
            $property_parts = [];
            $path_parts = explode("/", $full_property);
            for ($i = 1; $i < sizeof($path_parts); $i++) {
                $property_parts[$i] = explode("=", $path_parts[$i]);
            }
            for ($i = 1; $i < sizeof($path_parts); $i++) {
                if ($property_parts[$i][0] == $_entery) return $property_parts[$i][1];
            }
        }
    }

    public function path()
    {
        return (parse_url($this->link, PHP_URL_PATH) . "?" . parse_url($this->link, PHP_URL_QUERY));
    }

    public function query($_entery = null)
    {
        $info = parse_url($this->link, PHP_URL_QUERY);
        $query_parts = explode("&", $info);
        $full_query = "";

        for ($i = 0; $i < sizeof($query_parts); $i++) {
            $full_query .=  "&" . $query_parts[$i];
        }
        if ($_entery === null) return $full_query;
        else {
            $query_devided = [];
            $query_parts = explode("&", $full_query);
            for ($i = 1; $i < sizeof($query_parts); $i++) {
                $query_devided[$i] = explode("=", $query_parts[$i]);
            }
            for ($i = 1; $i < sizeof($query_parts); $i++) {
                if ($query_devided[$i][0] == $_entery) return $query_devided[$i][1];
            }
        }
    }

    public function fragment()
    {
        if (null !== parse_url($this->link, PHP_URL_FRAGMENT))  return (parse_url($this->link, PHP_URL_FRAGMENT));
        else return (null);
    }
}

$obj1 = new Url("https://ermile.tejarak.com:80/fa/cp/tools/sitemap/ch=1/sa=2?run=true&ex=0");

// var_dump("full -> " . $obj1->full());
// var_dump("user -> " . $obj1->user());
// var_dump("pass -> " . $obj1->pass());
// var_dump("base -> " . $obj1->base());
// var_dump("protocol -> " . $obj1->protocol());
// var_dump("sub_domain -> " . $obj1->sub_domain());
// var_dump("domain -> " . $obj1->domain());
// var_dump("root -> " . $obj1->root());
// var_dump("tld -> " . $obj1->tld());
// var_dump("port -> " . $obj1->port());
// var_dump("language -> " . $obj1->lang());
// var_dump("dir -> " . $obj1->dir());
// var_dump("content -> " . $obj1->content());
// var_dump("module -> " . $obj1->module());
// var_dump("child -> " . $obj1->child());
// var_dump("property -> " . $obj1->property());
// var_dump("path -> " . $obj1->path());
// var_dump("query -> " . $obj1->query());
// var_dump("fragment -> " . $obj1->fragment());