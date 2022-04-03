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

/* categories.html.twig */
class __TwigTemplate_429de219be28be9cf038c6521dd64a37c0b4448418541547ab187af2ad6a52e5 extends Template
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
        $this->parent = $this->loadTemplate("layout.html.twig", "categories.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "\t";
        if ((1 === twig_compare(twig_length_filter($this->env, ($context["categories"] ?? null)), 0))) {
            // line 4
            echo "\t<ul class=\"tilesWrap\">
\t\t";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
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
\t\t\t<a href=\"";
                // line 12
                echo twig_escape_filter($this->env, ($context["root_uri"] ?? null), "html", null, true);
                echo "/categories/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "id", [], "any", false, false, false, 12), "html", null, true);
                echo "\">
\t\t\t\t<button type=\"button\">Read more</button>
\t\t\t</a>
\t\t</li>
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "\t</ul>

\t";
        } else {
            // line 20
            echo "\t\t<h3>No categories found</h3>
\t";
        }
        // line 22
        echo "
";
    }

    public function getTemplateName()
    {
        return "categories.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 22,  95 => 20,  90 => 17,  77 => 12,  72 => 10,  67 => 8,  63 => 7,  60 => 6,  56 => 5,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"layout.html.twig\" %}
{% block content %}
\t{% if categories|length > 0 %}
\t<ul class=\"tilesWrap\">
\t\t{% for key, c in categories %}
\t\t<li>
\t\t\t<h2>{{key +1}}</h2>
\t\t\t<h3>{{c.libelle}}</h3>
\t\t\t<p>
\t\t\t\t{{c.description}}
\t\t\t</p>
\t\t\t<a href=\"{{ root_uri }}/categories/{{c.id}}\">
\t\t\t\t<button type=\"button\">Read more</button>
\t\t\t</a>
\t\t</li>
\t\t{% endfor %}
\t</ul>

\t{% else %}
\t\t<h3>No categories found</h3>
\t{% endif %}

{% endblock %}", "categories.html.twig", "/var/www/public/templates/categories.html.twig");
    }
}
