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

/* layout.html.twig */
class __TwigTemplate_dfc438435c535aec7cb0aa5cc260443681896e0f41ad4ea5eeb7ee9a3a496b6a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>

<head>
    <meta charset=\"utf-8\">
    <link rel=\"stylesheet\" href=\"../css/style.css\">
</head>

<body>
    <section id=\"main\">
        ";
        // line 11
        $this->displayBlock('content', $context, $blocks);
        // line 13
        echo "    </section>
</body>

</html>";
    }

    // line 11
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 12
        echo "        ";
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  63 => 12,  59 => 11,  52 => 13,  50 => 11,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>

<head>
    <meta charset=\"utf-8\">
    <link rel=\"stylesheet\" href=\"../css/style.css\">
</head>

<body>
    <section id=\"main\">
        {% block content %}
        {% endblock %}
    </section>
</body>

</html>", "layout.html.twig", "/var/www/public/templates/layout.html.twig");
    }
}
