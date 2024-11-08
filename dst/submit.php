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
    if (gettype($v) == 'integer') return $v;
    else return '';
}

function S($s){
    if (gettype($s) == 'string') return $s;
    else return '';
}

function A($a){
    if (gettype($a) == 'array') return $a;
    else return null;
}

function render_node($node){
    if ($node == null)
        return '';


    else if ($node['type'] == 'form')
        return
            '<form name="'.$node['name'].'">'.
                '<div>'.$node['label'].'</div>'.
                '</br>'.
                    implode('<br/>', array_map('render_node', $node['value'])).
                '</br>'.
                '<button type="submit" id="submit" class="button">'. 
                    $node['state'].
                '</button>'.
                '<script>
                    document
                        .querySelectorAll(`form[name="'.$node['name'].'"] div>select`)
                        .forEach(select => (
                            select.value = select.getAttribute(`state`),
                            select.dispatchEvent(new Event("change"))
                        ))

                    document
                        .querySelectorAll(`form[name="'.$node['name'].'"] div>input[type="checkbox"]`)
                        .forEach(checkbox => (
                            checkbox.checked = checkbox.getAttribute(`state`) == `false` && true || `true` && false || undefined,
                            checkbox.click()
                        ))
                </script>'. 
            '</form>';


    else if ($node['type'] == 'node')            
        return
            '<div id="'.$node['name'].'">'.
                '<div>'.$node['label'].'</div>'.
                '</br>'.
                    implode('<br/>', array_map('render_node', $node['value'])).
                '</br>'.
            '</div>';


    else if ($node['type'] == 'text')
        return
            '<div id="'.$node['name'].'">'.
                '<label for="'.$node['name'].'" >'. $node['label'].R($node['required']).'</label>'.
                '&nbsp;'.
                '<input type="text"'.' name="'.$node['name'].'" value="'.$node['value'].'" placeholder="'.$node['placeholder'].'" >'.
            '</div>';


    else if ($node['type'] == 'select')
        return
            '<div id="'.$node['name'].'">'.
                '<label for="'.$node['name'].'">'.$node['label'].R($node['required']).'</label>'.
                '&nbsp;'.
                '<select name="'.$node['name'].'" state="'.$node['state'].'">'.
                    implode('', array_map(
                        function($node){
                            return '<option value="'.$node['name'].'">'.V($node).$node['label'].' '.V($node['value']).'</option>';
                        },
                        $node['value']
                    )).
                '</select>'.
                implode('', array_map(
                    function($node){
                        return render_node(A($node['value']));
                    },
                    $node['value']
                )).
                '<script>
                    document
                        .querySelector(`[name="'.$node['name'].'"]`)
                        .addEventListener("change", e => (
                            document
                                .querySelectorAll(`#'.$node['name'].'>div`)
                                .forEach(div =>
                                    div.style.display = "none"
                                ),
                                document
                                .querySelector(`#'.$node['name'].'>#${e.target.value}`)
                                .style.display  = "revert"
                        ))
                </script>'.                
            '</div>';


    else if ($node['type'] == 'check')
        return
            '<div id="'.$node['name'].'">'.
                '<input type="checkbox"'.' name="'.$node['name'].'" value="'.V($node['value']).A($node['value'])['name'].'" state="'.$node['state'].'">'.
                '&nbsp;'.
                '<label for="'.$node['name'].'">'.' '.V($node['value']).' '.$node['label'].R($node['required']).'</label>'.
                render_node(A($node['value'])).
                '<script>
                    document
                        .querySelector(`[name="'.$node['name'].'"]`)
                        .addEventListener("change", e => 
                            document
                                .querySelector(`#'.A($node['value'])['name'].'`)
                                .style.display  = e.target.checked == false && "none" || e.target.checked == true && "revert" || undefined
                        )
                </script>'.
            '</div>';

    else
        return 
            '<div>'.
                '(some shit)'.
            '</div>';
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