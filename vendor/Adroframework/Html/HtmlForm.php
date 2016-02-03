<?php

/**
 * Html Form elemets
 *
 * @package Adroframework
 * @subpackage Html
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 */

class HtmlForm
{
    public static function label($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $formStartHtml = '<label for="' . $className . '_' . $name . '"';
        foreach ($htmlOptions as $prop => $value) {
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        $formStartHtml .= '>';
        foreach ($model->attributeLabels() as $keyName => $label) {
            if ($name == $keyName) {
                $formStartHtml .= $label;
            }
        }
        $formStartHtml .= '</label>' . PHP_EOL;
        return $formStartHtml;
    }

    /**
     * Input fields
     * <input> Defines an input control
     */

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function button($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="button" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $value        String Value of the checkbox
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function checkbox($model, $name, $value = null, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="checkbox" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$value.'"' . ($model->getAttribute($name)?'checked':'');
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
    }    

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function color($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="color" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function date($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="date" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function datetime($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="datetime" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;     
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function datetime_local($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="datetime-local" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;   
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function email($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="email" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;   
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function file($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="file" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;   
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $value        String Value of the checkbox
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function hidden($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="hidden" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;   
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function text($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="text" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className  . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
        
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function textarea($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<textarea name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '>'.$model->getAttribute($name).'</textarea>' . PHP_EOL;
        return $formStartHtml;
        
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function password($model, $name, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<input type="password" name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '/>' . PHP_EOL;
        return $formStartHtml;
        
    }

    /**
     * @param   $model        Form   Form Model
     * @param   $name         String Name of form model attribute
     * @param   $data         array  key value pair
     * @param   $htmlOptions  Array  Html options
     * @return  String
     */
    public static function select($model, $name, $data, $htmlOptions = array())
    {
        $className = get_class($model);
        $addErrorClass = ($model->getError($name))? ' error':'';
        $hasAddedError = ($model->getError($name))? true:false;
        $formStartHtml = '<select name="' . $className . '[' . $name . ']"';
        $formStartHtml .= ' id="' . $className . '_' . $name . '"' . ' value="'.$model->getAttribute($name).'"';
        foreach ($htmlOptions as $prop => $value) {
            if($prop == 'class' && $hasAddedError) {
                $value .= $addErrorClass;
            }
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        if ($hasAddedError) {
            $formStartHtml .= ' class="error"';
        }
        $formStartHtml .= '>' . PHP_EOL;

        foreach ($data as $key => $value) {
            $selected = ($model->getAttribute($name) == $value)?'selected':'';
            $formStartHtml .= '<option value ="' . $value . '" '.$selected.'>' . $key . '</option>';
        }
          $formStartHtml .= '</select>';
        return $formStartHtml;
        
    }

    public static function submit($name = null, $htmlOptions = array())
    {
        $formStartHtml = '<input type="submit"';
        foreach ($htmlOptions as $prop => $value) {
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        $formStartHtml .= '/>' . PHP_EOL;

        return $formStartHtml;
    }
}