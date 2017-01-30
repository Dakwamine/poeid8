<?php

/* modules/contrib/views_slideshow/templates/views-view-slideshow.html.twig */
class __TwigTemplate_c60ef2772e68ecf5d74523872b8dc64bb2ac8e629d01ea4323b5fab296c7bb4c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("if" => 17);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 17
        if ((isset($context["slideshow"]) ? $context["slideshow"] : null)) {
            // line 18
            echo "  <div class=\"skin-";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["skin"]) ? $context["skin"] : null), "html", null, true));
            echo "\">
    ";
            // line 19
            if ((isset($context["top_widget_rendered"]) ? $context["top_widget_rendered"] : null)) {
                // line 20
                echo "      <div class=\"views-slideshow-controls-top clearfix\">
        ";
                // line 21
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["top_widget_rendered"]) ? $context["top_widget_rendered"] : null), "html", null, true));
                echo "
      </div>
    ";
            }
            // line 24
            echo "
    ";
            // line 25
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["slideshow"]) ? $context["slideshow"] : null), "html", null, true));
            echo "

    ";
            // line 27
            if ((isset($context["bottom_widget_rendered"]) ? $context["bottom_widget_rendered"] : null)) {
                // line 28
                echo "      <div class=\"views-slideshow-controls-bottom clearfix\">
        ";
                // line 29
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["bottom_widget_rendered"]) ? $context["bottom_widget_rendered"] : null), "html", null, true));
                echo "
      </div>
    ";
            }
            // line 32
            echo "    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/contrib/views_slideshow/templates/views-view-slideshow.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 32,  74 => 29,  71 => 28,  69 => 27,  64 => 25,  61 => 24,  55 => 21,  52 => 20,  50 => 19,  45 => 18,  43 => 17,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation for a views slideshow.*/
/*  **/
/*  * Available variables:*/
/*  * - bottom_widget_rendered: Widget under the slideshow with controls/data.*/
/*  * - skin: The skin being applied to the slideshow.*/
/*  * - slideshow: The slideshow.*/
/*  * - top_widget_rendered: Widget above the slideshow with controls/data.*/
/*  **/
/*  * @see _views_slideshow_preprocess_views_view_slideshow()*/
/*  **/
/*  * @ingroup themeable*/
/*  *//* */
/* #}*/
/* {% if slideshow %}*/
/*   <div class="skin-{{ skin }}">*/
/*     {% if top_widget_rendered %}*/
/*       <div class="views-slideshow-controls-top clearfix">*/
/*         {{ top_widget_rendered }}*/
/*       </div>*/
/*     {% endif %}*/
/* */
/*     {{ slideshow }}*/
/* */
/*     {% if bottom_widget_rendered %}*/
/*       <div class="views-slideshow-controls-bottom clearfix">*/
/*         {{ bottom_widget_rendered }}*/
/*       </div>*/
/*     {% endif %}*/
/*     </div>*/
/* {% endif %}*/
/* */
