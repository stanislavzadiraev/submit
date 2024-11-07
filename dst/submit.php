<?php
/**
 * @wordpress-plugin
 * Plugin Name: Submit
 * Text Domain: submit
 */

function R($r){
    if ($r) return ' * ';
    else return ' ';
}

function V($v){
    if (gettype($v) == 'integer') return '/ '.$v.' /';
    else return '';
}

function render_node($node){
    if ($node['type'] == 'form')
        return '<form name="'.$node['name'].'">'.
            $node['label'].
            '</br>'.
            implode('<br/>', array_map('render_node', $node['value'])).
            '</br>'.
            '<button type="submit" id="submit" class="button">'. 
                $node['state'].
            '</button>'.
            '<script>
                document
                    .querySelectorAll(`form[name="'.$node['name'].'"]>select`)
                    .forEach(select =>
                        select
                            .value = select.getAttribute(`state`)
                    )

                document
                    .querySelectorAll(`form[name="'.$node['name'].'"]>input[type="checkbox"]`)
                    .forEach(checkbox =>
                        checkbox
                            .checked = checkbox.getAttribute(`state`) == `true` && true || false
                        )
            </script>'. 
        '</form>';


    else if ($node['type'] == 'value')
        return $node['value'];


    else if ($node['type'] == 'text')
        return '<label for="'.$node['name'].'" >'. $node['label'].R($node['required']).'</label>'.
        '&nbsp;'.
        '<input type="text"'.' name="'.$node['name'].'" value="'.$node['value'].'" placeholder="'.$node['placeholder'].'" >';


    else if ($node['type'] == 'select')
        return '<label for="'.$node['name'].'">'.$node['label'].R($node['required']).'</label>'.
        '&nbsp;'.
        '<select name="'.$node['name'].'" state="'.$node['state'].'">'.
            implode('', array_map(
                function($node){
                    return '<option value="'.$node['name'].'">'.$node['label'].' '.V($node['value']).'</option>';
                },
                $node['value']
            )).
        '</select>';


    else if ($node['type'] == 'check')
        return '<input type="checkbox"'.' name="'.$node['name'].'" state="'.$node['state'].'">'.
        '&nbsp;'.
        '<label for="'.$node['name'].'">'.' '.V($node['value']).' '.$node['label'].R($node['required']).'</label>';

        
    else
        return '(some shit)';
}

add_shortcode(
    'submit',
    function ($atts) {
        $atts = shortcode_atts(array('form' => ''), $atts);
        $node = include plugin_dir_path(__FILE__) . 'forms/' . $atts['form'];

        return render_node($node);
    }
);
 
?>