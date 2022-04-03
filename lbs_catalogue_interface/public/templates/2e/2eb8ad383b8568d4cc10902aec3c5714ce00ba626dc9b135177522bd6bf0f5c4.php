<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* sandwiches.html.twig */
class __TwigTemplate_005a11cfcca7edca5a7225cd2014182393074c21d6585c819efcba86ef168470 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html.twig", "sandwiches.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "\t";
        if ((1 === twig_compare(twig_length_filter($this->env, ($context["sandwiches"] ?? null)), 0))) {
            // line 4
            echo "\t<ul class=\"tilesWrap\">
\t\t";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["sandwiches"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["c"]) {
                // line 6
                echo "\t\t<li>
\t\t\t<h2>";
                // line 7
                echo twig_escape_filter($this->env, ($context["key"] + 1), "html", null, true);
                echo "</h2>
\t\t\t<h3>";
                // line 8
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "libelle", [], "any", false, false, false, 8), "html", null, true);
                echo "</h3>
\t\t\t<p>
\t\t\t\t";
                // line 10
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "description", [], "any", false, false, false, 10), "html", null, true);
                echo "
\t\t\t</p>
\t\t\t<h3>";
                // line 12
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "prix", [], "any", false, false, false, 12), 2), "html", null, true);
                echo " €</h3>
\t\t</li>
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "\t</ul>

\t";
        } else {
            // line 18
            echo "\t\t<h3>No sandwiches found</h3>
\t";
        }
        // line 20
        echo "\t<a class=\"back\" href=\"";
        echo twig_escape_filter($this->env, ($context["root_uri"] ?? null), "html", null, true);
        echo "/categories\"> Go back</a>

";
    }

    public function getTemplateName()
    {
        return "sandwiches.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 20,  91 => 18,  86 => 15,  77 => 12,  72 => 10,  67 => 8,  63 => 7,  60 => 6,  56 => 5,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"layout.html.twig\" %}
{% block content %}
\t{% if sandwiches|length > 0 %}
\t<ul class=\"tilesWrap\">
\t\t{% for key, c in sandwiches %}
\t\t<li>
\t\t\t<h2>{{key +1}}</h2>
\t\t\t<h3>{{c.libelle}}</h3>
\t\t\t<p>
\t\t\t\t{{c.description}}
\t\t\t</p>
\t\t\t<h3>{{c.prix|number_format(2)}} €</h3>
\t\t</li>
\t\t{% endfor %}
\t</ul>

\t{% else %}
\t\t<h3>No sandwiches found</h3>
\t{% endif %}
\t<a class=\"back\" href=\"{{ root_uri }}/categories\"> Go back</a>

{% endblock %}", "sandwiches.html.twig", "/var/www/public/templates/sandwiches.html.twig");
    }
}
