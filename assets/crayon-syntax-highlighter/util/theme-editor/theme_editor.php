<?php

class Element {
    public $id;
    public $class = '';
    public $tag = 'div';
    public $closed = FALSE;
    public $contents = '';
    public $attributes = array();
    const CSS_INPUT_PREFIX = "crayon-theme-input-";

    public function __construct($id) {
        $this->id = $id;
    }

    public function addClass($class) {
        $this->class .= ' ' . self::CSS_INPUT_PREFIX . $class;
    }

    public function addAttributes($atts) {
        $this->attributes = array_merge($this->attributes, $atts);
    }

    public function attributeString() {
        $str = '';
        foreach ($this->attributes as $k => $v) {
            $str .= "$k=\"$v\" ";
        }
        return $str;
    }

    public function __toString() {
        return '<' . $this->tag . ' id="' . self::CSS_INPUT_PREFIX . $this->id . '" class="' . self::CSS_INPUT_PREFIX . $this->class . '" ' . $this->attributeString() . ($this->closed ? ' />' : ' >' . $this->contents . "</$this->tag>");
    }
}

class Input extends Element {
    public $name;
    public $type;

    public function __construct($id, $name = NULL, $value = '', $type = 'text') {
        parent::__construct($id);
        $this->tag = 'input';
        $this->closed = TRUE;
        if ($name === NULL) {
            $name = CrayonUserResource::clean_name($id);
        }
        $this->name = $name;
        $this->class .= $type;
        $this->addAttributes(array(
            'type' => $type,
            'value' => $value
        ));
    }
}

class Select extends Input {
    public $options;
    public $selected = NULL;

    public function __construct($id, $name = NULL, $value = '', $options = array()) {
        parent::__construct($id, $name, 'select');
        $this->tag = 'select';
        $this->closed = FALSE;
        $this->addOptions($options);
    }

    public function addOptions($options, $default = NULL) {
        for ($i = 0; $i < count($options); $i++) {
            $key = $options[$i];
            $value = isset($options[$key]) ? $options[$key] : $key;
            $this->options[$key] = $value;
        }
        if ($default === NULL && count($options) > 1) {
            $this->attributes['data-default'] = $options[0];
        } else {
            $this->attributes['data-default'] = $default;
        }
    }

    public function getOptionsString() {
        $str = '';
        foreach ($this->options as $k => $v) {
            $selected = $this->selected == $k ? 'selected="selected"' : '';
            $str .= "<option value=\"$k\" $selected>$v</option>";
        }
        return $str;
    }

    public function __toString() {
        $this->contents = $this->getOptionsString();
        return parent::__toString();
    }
}

class Separator extends Element {
    public $name = '';

    public function __construct($name) {
        parent::__construct($name);
        $this->name = $name;
    }
}

class Title extends Separator {

}

class CrayonThemeEditorWP {

    public static $attributes = NULL;
    public static $attributeGroups = NULL;
    public static $attributeGroupsInverse = NULL;
    public static $attributeTypes = NULL;
    public static $attributeTypesInverse = NULL;
    public static $infoFields = NULL;
    public static $infoFieldsInverse = NULL;
    public static $settings = NULL;
    public static $strings = NULL;

    const ATTRIBUTE = 'attribute';

    const RE_COMMENT = '#^\s*\/\*[\s\S]*?\*\/#msi';

    public static function init() {
        self::admin_resources();
    }

    public static function initFields() {
        if (self::$infoFields === NULL) {
            self::$infoFields = array(
                // These are canonical and can't be translated, since they appear in the comments of the CSS
                'name' => 'Name',
                'description' => 'Description',
                'version' => 'Version',
                'author' => 'Author',
                'url' => 'URL',
                'original-author' => 'Original Author',
                'notes' => 'Notes',
                'maintainer' => 'Maintainer',
                'maintainer-url' => 'Maintainer URL'
            );
            self::$infoFieldsInverse = CrayonUtil::array_flip(self::$infoFields);
            // A map of CSS element name and property to name
            self::$attributes = array();
            // A map of CSS attribute to input type
            self::$attributeGroups = array(
                'color' => array('background', 'background-color', 'border-color', 'color', 'border-top-color', 'border-bottom-color'),
                'size' => array('border-width'),
                'border-style' => array('border-style', 'border-bottom-style', 'border-top-style')
            );
            self::$attributeGroupsInverse = CrayonUtil::array_flip(self::$attributeGroups);
            // Mapping of input type to attribute group
            self::$attributeTypes = array(
                'select' => array('border-style', 'font-style', 'font-weight', 'text-decoration')
            );
            self::$attributeTypesInverse = CrayonUtil::array_flip(self::$attributeTypes);
        }
    }

    public static function initSettings() {

        self::initFields();
        self::initStrings();
        if (self::$settings === NULL) {
            self::$settings = array(
                // Only things the theme editor needs
                'cssThemePrefix' => CrayonThemes::CSS_PREFIX,
                'cssInputPrefix' => Element::CSS_INPUT_PREFIX,
                'attribute' => self::ATTRIBUTE,
                'fields' => self::$infoFields,
                'fieldsInverse' => self::$infoFieldsInverse,
                'prefix' => 'crayon-theme-editor'
            );
        }
    }

    public static function initStrings() {
        if (self::$strings === NULL) {
            self::$strings = array(
                // These appear only in the UI and can be translated
                // TODO add the rest
                'no' => crayon__("No"),
                'yes' => crayon__("Yes"),
                'userTheme' => crayon__("User-Defined Theme"),
                'stockTheme' => crayon__("Stock Theme"),
                'success' => crayon__("Success!"),
                'fail' => crayon__("Failed!"),
                'delete' => crayon__("Delete"),
                'deleteThemeConfirm' => crayon__("Are you sure you want to delete the \"%s\" theme?"),
                'deleteFail' => crayon__("Delete failed!"),
                'duplicate' => crayon__("Duplicate"),
                'newName' => crayon__("New Name"),
                'duplicateFail' => crayon__("Duplicate failed!"),
                'checkLog' => crayon__("Please check the log for details."),
                'discardConfirm' => crayon__("Are you sure you want to discard all changes?"),
                'confirm' => crayon__("Confirm"),
                'editingTheme' => crayon__("Editing Theme: %s"),
                'creatingTheme' => crayon__("Creating Theme: %s"),
                'prompt' => crayon__("Prompt"),
                'value' => crayon__("Value"),
                'alert' => crayon__("Alert"),
                'submit' => crayon__("Submit Your Theme"),
                'submitText' => crayon__("Submit your User Theme for inclusion as a Stock Theme in Crayon!"),
                'message' => crayon__("Message"),
                'submitMessage' => crayon__("Please include this theme in Crayon!"),
                'submitSucceed' => crayon__("Submit was successful."),
                'submitFail' => crayon__("Submit failed!"),
            );
        }
    }

    public static function admin_resources() {
        global $CRAYON_VERSION;
        self::initSettings();
        $path = dirname(dirname(__FILE__));
        wp_enqueue_script('cssjson_js', plugins_url(CRAYON_CSSJSON_JS, $path), $CRAYON_VERSION);
        wp_enqueue_script('jquery_ui_js', plugins_url(CRAYON_JS_JQUERY_UI, $path), array('jquery'), $CRAYON_VERSION);
        wp_enqueue_script('jquery_colorpicker_js', plugins_url(CRAYON_JS_JQUERY_COLORPICKER, $path), array('jquery'), $CRAYON_VERSION);
        wp_enqueue_script('jquery_tinycolor_js', plugins_url(CRAYON_JS_TINYCOLOR, $path), array(), $CRAYON_VERSION);
        wp_enqueue_script('crayon_theme_editor', plugins_url(CRAYON_THEME_EDITOR_JS, $path), array('jquery', 'jquery_ui_js', 'crayon_util_js', 'crayon_admin_js', 'cssjson_js', 'jquery_colorpicker_js', 'jquery_tinycolor_js'), $CRAYON_VERSION);
        wp_localize_script('crayon_theme_editor', 'CrayonThemeEditorSettings', self::$settings);
        wp_localize_script('crayon_theme_editor', 'CrayonThemeEditorStrings', self::$strings);

        wp_enqueue_style('jquery_ui', plugins_url(CRAYON_CSS_JQUERY_UI, $path), array(), $CRAYON_VERSION);
        wp_enqueue_style('jquery_colorpicker', plugins_url(CRAYON_CSS_JQUERY_COLORPICKER, $path), array(), $CRAYON_VERSION);
    }

    public static function form($inputs) {
        $str = '<form class="' . self::$settings['prefix'] . '-form"><table>';
        $sepCount = 0;
        foreach ($inputs as $input) {
            if ($input instanceof Input) {
                $str .= self::formField($input->name, $input);
            } else if ($input instanceof Separator) {
                $sepClass = '';
                if ($input instanceof Title) {
                    $sepClass .= ' title';
                }
                if ($sepCount == 0) {
                    $sepClass .= ' first';
                }
                $str .= '<tr class="separator' . $sepClass . '"><td colspan="2"><div class="content">' . $input->name . '</div></td></tr>';
                $sepCount++;
            } else if (is_array($input) && count($input) > 1) {
                $name = $input[0];
                $fields = '<table class="split-field"><tr>';
                $percent = 100 / count($input);
                for ($i = 1; $i < count($input); $i++) {
                    $class = $i == count($input) - 1 ? 'class="last"' : '';
                    $fields .= '<td ' . $class . ' style="width: ' . $percent . '%">' . $input[$i] . '</td>';
                }
                $fields .= '</tr></table>';
                $str .= self::formField($name, $fields, 'split');
            }
        }
        $str .= '</table></form>';
        return $str;
    }

    public static function formField($name, $field, $class = '') {
        return '<tr><td class="field ' . $class . '">' . $name . '</td><td class="value ' . $class . '">' . $field . '</td></tr>';
    }

    public static function content() {
        self::initSettings();
        $theme = CrayonResources::themes()->get_default();
        $editing = false;

        if (isset($_GET['curr_theme'])) {
            $currTheme = CrayonResources::themes()->get($_GET['curr_theme']);
            if ($currTheme) {
                $theme = $currTheme;
            }
        }

        if (isset($_GET['editing'])) {
            $editing = CrayonUtil::str_to_bool($_GET['editing'], FALSE);
        }

        $tInformation = crayon__("Information");
        $tHighlighting = crayon__("Highlighting");
        $tFrame = crayon__("Frame");
        $tLines = crayon__("Lines");
        $tNumbers = crayon__("Line Numbers");
        $tToolbar = crayon__("Toolbar");

        $tBackground = crayon__("Background");
        $tText = crayon__("Text");
        $tBorder = crayon__("Border");
        $tTopBorder = crayon__("Top Border");
        $tBottomBorder = crayon__("Bottom Border");

        $tHover = crayon__("Hover");
        $tActive = crayon__("Active");
        $tPressed = crayon__("Pressed");
        $tHoverPressed = crayon__("Pressed & Hover");
        $tActivePressed = crayon__("Pressed & Active");

        $tTitle = crayon__("Title");
        $tButtons = crayon__("Buttons");

        $tNormal = crayon__("Normal");
        $tInline = crayon__("Inline");
        $tStriped = crayon__("Striped");
        $tMarked = crayon__("Marked");
        $tStripedMarked = crayon__("Striped & Marked");
        $tLanguage = crayon__("Language");

        $top = '.crayon-top';
        $bottom = '.crayon-bottom';
        $hover = ':hover';
        $active = ':active';
        $pressed = '.crayon-pressed';

        ?>

    <div
            id="icon-options-general" class="icon32"></div>
    <h2>
        Crayon Syntax Highlighter
        <?php crayon_e('Theme Editor'); ?>
    </h2>

    <h3 id="<?php echo self::$settings['prefix'] ?>-name">
        <?php
//			if ($editing) {
//				echo sprintf(crayon__('Editing "%s" Theme'), $theme->name());
//			} else {
//				echo sprintf(crayon__('Creating Theme From "%s"'), $theme->name());
//			}
        ?>
    </h3>
    <div id="<?php echo self::$settings['prefix'] ?>-info"></div>

    <p>
        <a id="crayon-editor-back" class="button-primary"><?php crayon_e("Back To Settings"); ?></a>
        <a id="crayon-editor-save" class="button-primary"><?php crayon_e("Save"); ?></a>
        <span id="crayon-editor-status"></span>
    </p>

    <?php //crayon_e('Use the Sidebar on the right to change the Theme of the Preview window.') ?>

    <div id="crayon-editor-top-controls"></div>

    <table id="crayon-editor-table" style="width: 100%;" cellspacing="5"
           cellpadding="0">
        <tr>
            <td id="crayon-editor-preview-wrapper">
                <div id="crayon-editor-preview"></div>
            </td>
            <div id="crayon-editor-preview-css"></div>
            <td id="crayon-editor-control-wrapper">
                <div id="crayon-editor-controls">
                    <ul>
                        <li title="<?php echo $tInformation ?>"><a class="crayon-tab-information" href="#tabs-1"></a></li>
                        <li title="<?php echo $tHighlighting ?>"><a class="crayon-tab-highlighting" href="#tabs-2"></a></li>
                        <li title="<?php echo $tFrame ?>"><a class="crayon-tab-frame" href="#tabs-3"></a></li>
                        <li title="<?php echo $tLines ?>"><a class="crayon-tab-lines" href="#tabs-4"></a></li>
                        <li title="<?php echo $tNumbers ?>"><a class="crayon-tab-numbers" href="#tabs-5"></a></li>
                        <li title="<?php echo $tToolbar ?>"><a class="crayon-tab-toolbar" href="#tabs-6"></a></li>
                    </ul>
                    <div id="tabs-1">
                        <?php
                        self::createAttributesForm(array(
                            new Title($tInformation)
                        ));
                        ?>
                        <div id="tabs-1-contents"></div>
                        <!-- Auto-filled by theme_editor.js -->
                    </div>
                    <div id="tabs-2">
                        <?php
                        $highlight = ' .crayon-pre .';
                        $elems = array(
                            'c' => crayon__("Comment"),
                            's' => crayon__("String"),
                            'p' => crayon__("Preprocessor"),
                            'ta' => crayon__("Tag"),
                            'k' => crayon__("Keyword"),
                            'st' => crayon__("Statement"),
                            'r' => crayon__("Reserved"),
                            't' => crayon__("Type"),
                            'm' => crayon__("Modifier"),
                            'i' => crayon__("Identifier"),
                            'e' => crayon__("Entity"),
                            'v' => crayon__("Variable"),
                            'cn' => crayon__("Constant"),
                            'o' => crayon__("Operator"),
                            'sy' => crayon__("Symbol"),
                            'n' => crayon__("Notation"),
                            'f' => crayon__("Faded"),
                            'h' => crayon__("HTML")
                        );
                        $atts = array(new Title($tHighlighting));
                        foreach ($elems as $class => $name) {
                            $atts[] = array(
                                $name,
                                self::createAttribute($highlight . $class, 'color'),
                                self::createAttribute($highlight . $class, 'font-weight'),
                                self::createAttribute($highlight . $class, 'font-style'),
                                self::createAttribute($highlight . $class, 'text-decoration')
                            );
                        }
                        self::createAttributesForm($atts);
                        ?>
                    </div>
                    <div id="tabs-3">
                        <?php
                        $inline = '-inline';
                        self::createAttributesForm(array(
                            new Title($tFrame),
                            new Separator($tNormal),
//                            self::createAttribute('', 'background', $tBackground),
                            array(
                                $tBorder,
                                self::createAttribute('', 'border-width'),
                                self::createAttribute('', 'border-color'),
                                self::createAttribute('', 'border-style')
                            ),
                            new Separator($tInline),
                            self::createAttribute($inline, 'background', $tBackground),
                            array(
                                $tBorder,
                                self::createAttribute($inline, 'border-width'),
                                self::createAttribute($inline, 'border-color'),
                                self::createAttribute($inline, 'border-style')
                            ),
                        ));
                        ?>
                    </div>
                    <div id="tabs-4">
                        <?php
                        $stripedLine = ' .crayon-striped-line';
                        $markedLine = ' .crayon-marked-line';
                        $stripedMarkedLine = ' .crayon-marked-line.crayon-striped-line';
                        self::createAttributesForm(array(
                            new Title($tLines),
                            new Separator($tNormal),
                            self::createAttribute('', 'background', $tBackground),
                            new Separator($tStriped),
                            self::createAttribute($stripedLine, 'background', $tBackground),
                            new Separator($tMarked),
                            self::createAttribute($markedLine, 'background', $tBackground),
                            array(
                                $tBorder,
                                self::createAttribute($markedLine, 'border-width'),
                                self::createAttribute($markedLine, 'border-color'),
                                self::createAttribute($markedLine, 'border-style'),
                            ),
                            self::createAttribute($markedLine . $top, 'border-top-style', $tTopBorder),
                            self::createAttribute($markedLine . $bottom, 'border-bottom-style', $tBottomBorder),
                            new Separator($tStripedMarked),
                            self::createAttribute($stripedMarkedLine, 'background', $tBackground),
                        ));
                        ?>
                    </div>
                    <div id="tabs-5">
                        <?php
                        $nums = ' .crayon-table .crayon-nums';
                        $stripedNum = ' .crayon-striped-num';
                        $markedNum = ' .crayon-marked-num';
                        $stripedMarkedNum = ' .crayon-marked-num.crayon-striped-num';
                        self::createAttributesForm(array(
                            new Title($tNumbers),
                            new Separator($tNormal),
                            self::createAttribute($nums, 'background', $tBackground),
                            self::createAttribute($nums, 'color', $tText),
                            new Separator($tStriped),
                            self::createAttribute($stripedNum, 'background', $tBackground),
                            self::createAttribute($stripedNum, 'color', $tText),
                            new Separator($tMarked),
                            self::createAttribute($markedNum, 'background', $tBackground),
                            self::createAttribute($markedNum, 'color', $tText),
                            array(
                                $tBorder,
                                self::createAttribute($markedNum, 'border-width'),
                                self::createAttribute($markedNum, 'border-color'),
                                self::createAttribute($markedNum, 'border-style'),
                            ),
                            self::createAttribute($markedNum.$top, 'border-top-style', $tTopBorder),
                            self::createAttribute($markedNum.$bottom, 'border-bottom-style', $tBottomBorder),
                            new Separator($tStripedMarked),
                            self::createAttribute($stripedMarkedNum, 'background', $tBackground),
                            self::createAttribute($stripedMarkedNum, 'color', $tText),
                        ));
                        ?>
                    </div>
                    <div id="tabs-6">
                        <?php
                        $toolbar = ' .crayon-toolbar';
                        $title = ' .crayon-title';
                        $button = ' a.crayon-button';
                        $info = ' .crayon-info';
                        $language = ' .crayon-language';
                        self::createAttributesForm(array(
                            new Title($tToolbar),
                            new Separator($tFrame),
                            self::createAttribute($toolbar, 'background', $tBackground),
                            array(
                                $tBottomBorder,
                                self::createAttribute($toolbar, 'border-bottom-width'),
                                self::createAttribute($toolbar, 'border-bottom-color'),
                                self::createAttribute($toolbar, 'border-bottom-style'),
                            ),
                            array(
                                $tTitle,
                                self::createAttribute($title, 'color'),
                                self::createAttribute($title, 'font-weight'),
                                self::createAttribute($title, 'font-style'),
                                self::createAttribute($title, 'text-decoration')
                            ),
                            new Separator($tButtons),
                            self::createAttribute($button, 'background-color', $tBackground),
                            self::createAttribute($button.$hover, 'background-color', $tHover),
                            self::createAttribute($button.$active, 'background-color', $tActive),
                            self::createAttribute($button.$pressed, 'background-color', $tPressed),
                            self::createAttribute($button.$pressed.$hover, 'background-color', $tHoverPressed),
                            self::createAttribute($button.$pressed.$active, 'background-color', $tActivePressed),
                            new Separator($tInformation . ' ' . crayon__("(Used for Copy/Paste)")),
                            self::createAttribute($info, 'background', $tBackground),
                            array(
                                $tText,
                                self::createAttribute($info, 'color'),
                                self::createAttribute($info, 'font-weight'),
                                self::createAttribute($info, 'font-style'),
                                self::createAttribute($info, 'text-decoration')
                            ),
                            array(
                                $tBottomBorder,
                                self::createAttribute($info, 'border-bottom-width'),
                                self::createAttribute($info, 'border-bottom-color'),
                                self::createAttribute($info, 'border-bottom-style'),
                            ),
                            new Separator($tLanguage),
                            array(
                                $tText,
                                self::createAttribute($language, 'color'),
                                self::createAttribute($language, 'font-weight'),
                                self::createAttribute($language, 'font-style'),
                                self::createAttribute($language, 'text-decoration')
                            ),
//                            self::createAttribute($toolbar.' > div', 'float', crayon__("Title Float")),
//                            self::createAttribute($toolbar.' .crayon-tools', 'float', crayon__("Buttons Float"))
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>

    </table>

    <?php
        exit();
    }

    public static function createAttribute($element, $attribute, $name = NULL) {
        $group = self::getAttributeGroup($attribute);
        $type = self::getAttributeType($group);
        if ($type == 'select') {
            $input = new Select($element . '_' . $attribute, $name);
            if ($group == 'border-style') {
                $input->addOptions(array(
                    'none',
                    'hidden',
                    'dotted',
                    'dashed',
                    'solid',
                    'double',
                    'groove',
                    'ridge',
                    'inset',
                    'outset',
                    'inherit'
                ));
            } else if ($group == 'float') {
                $input->addOptions(array(
                    'left',
                    'right',
                    'both',
                    'none',
                    'inherit'
                ));
            } else if ($group == 'font-style') {
                $input->addOptions(array(
                    'normal',
                    'italic',
                    'oblique',
                    'inherit'
                ));
            } else if ($group == 'font-weight') {
                $input->addOptions(array(
                    'normal',
                    'bold',
                    'bolder',
                    'lighter',
                    '100',
                    '200',
                    '300',
                    '400',
                    '500',
                    '600',
                    '700',
                    '800',
                    '900',
                    'inherit'
                ));
            } else if ($group == 'text-decoration') {
                $input->addOptions(array(
                    'none',
                    'underline',
                    'overline',
                    'line-through',
                    'blink',
                    'inherit'
                ));
            }
        } else {
            $input = new Input($element . '_' . $attribute, $name);
        }
        $input->addClass(self::ATTRIBUTE);
        $input->addAttributes(array(
            'data-element' => $element,
            'data-attribute' => $attribute,
            'data-group' => $group
        ));
        return $input;
    }

    public static function createAttributesForm($atts) {
        echo self::form($atts);
    }

    /**
     * Saves the given theme id and css, making any necessary path and id changes to ensure the new theme is valid.
     * Echos 0 on failure, 1 on success and 2 on success and if paths have changed.
     */
    public static function save($allow_edit_stock_theme = NULL) {
        CrayonSettingsWP::load_settings();
        $oldID = $_POST['id'];
        $name = $_POST['name'];
        $css = stripslashes($_POST['css']);
        $change_settings = CrayonUtil::set_default($_POST['change_settings'], TRUE);
        $allow_edit = CrayonUtil::set_default($_POST['allow_edit'], TRUE);
        $allow_edit_stock_theme = CrayonUtil::set_default_null($allow_edit_stock_theme, CRAYON_DEBUG);
        $delete = CrayonUtil::set_default($_POST['delete'], TRUE);
        $oldTheme = CrayonResources::themes()->get($oldID);

        if (!empty($oldID) && !empty($css) && !empty($name)) {
            // By default, expect a user theme to be saved - prevents editing stock themes
            // If in DEBUG mode, then allow editing stock themes.
            $user = $oldTheme !== NULL && $allow_edit_stock_theme ? $oldTheme->user() : TRUE;
            $oldPath = CrayonResources::themes()->path($oldID);
            $oldDir = CrayonResources::themes()->dirpath($oldID);
            $newID = CrayonResource::clean_id($name);
            $newPath = CrayonResources::themes()->path($newID, $user);
            $newDir = CrayonResources::themes()->dirpath($newID, $user);

            $exists = CrayonResources::themes()->is_loaded($newID) || (is_file($newPath) && is_file($oldPath));
            if ($exists && $oldPath != $newPath) {
                // Never allow overwriting a theme with a different id!
                echo -3;
                exit();
            }
            
            if ($oldPath == $newPath && $allow_edit === FALSE) {
                // Don't allow editing
                echo -4;
                exit();
            }

            // Create the new path if needed
            if (!is_file($newPath)) {
                if (!is_dir($newDir)) {
                    mkdir($newDir, 0777, TRUE);
                    try {
                        // Copy image folder
                        CrayonUtil::copyDir($oldDir . 'images', $newDir . 'images');
                    } catch (Exception $e) {
                        CrayonLog::syslog($e->getMessage(), "THEME SAVE");
                    }
                }
            }

            $refresh = FALSE;
            $replaceID = $oldID;
            // Replace ids in the CSS
            if (!is_file($oldPath) || strpos($css, CrayonThemes::CSS_PREFIX . $oldID) === FALSE) {
                // The old path/id is no longer valid - something has gone wrong - we should refresh afterwards
                $refresh = TRUE;
                // Forces the ids to be updated
                $replaceID = '[\w-]+';
            }
            // XXX This is case sensitive to avoid modifying text, but it means that CSS must be in lowercase
            $css = preg_replace('#(?<=' . CrayonThemes::CSS_PREFIX . ')' . $replaceID . '\b#ms', $newID, $css);

            // Replace the name with the new one
            $info = self::getCSSInfo($css);
            $info['name'] = $name;
            $css = self::setCSSInfo($css, $info);

            $result = @file_put_contents($newPath, $css);
            $success = $result !== FALSE;
            if ($success && $oldPath !== $newPath) {
                if ($oldID !== CrayonThemes::DEFAULT_THEME && $delete) {
                    // Only delete the old path if it isn't the default theme
                    try {
                        // Delete the old path
                        CrayonUtil::deleteDir($oldDir);
                    } catch (Exception $e) {
                        CrayonLog::syslog($e->getMessage(), "THEME SAVE");
                    }
                }
                // Refresh
                echo 2;
            } else {
                if ($refresh) {
                    echo 2;
                } else {
                    if ($success) {
                        echo 1;
                    } else {
                        echo -2;
                    }
                }
            }
            // Set the new theme in settings
            if ($change_settings) {
                CrayonGlobalSettings::set(CrayonSettings::THEME, $newID);
                CrayonSettingsWP::save_settings();
            }
        } else {
            CrayonLog::syslog("$oldID=$oldID\n\n$name=$name", "THEME SAVE");
            echo -1;
        }
        exit();
    }

    public static function duplicate() {
        CrayonSettingsWP::load_settings();
        $oldID = $_POST['id'];
        $oldPath = CrayonResources::themes()->path($oldID);
        $_POST['css'] = file_get_contents($oldPath);
        $_POST['delete'] = FALSE;
        $_POST['allow_edit'] = FALSE;
        self::save(FALSE);
    }

    public static function delete() {
        CrayonSettingsWP::load_settings();
        $id = $_POST['id'];
        $dir = CrayonResources::themes()->dirpath($id);
        if (is_dir($dir) && CrayonResources::themes()->exists($id)) {
            try {
                CrayonUtil::deleteDir($dir);
                CrayonGlobalSettings::set(CrayonSettings::THEME, CrayonThemes::DEFAULT_THEME);
                CrayonSettingsWP::save_settings();
                echo 1;
            } catch (Exception $e) {
                CrayonLog::syslog($e->getMessage(), "THEME SAVE");
                echo -2;
            }
        } else {
            echo -1;
        }
        exit();
    }

    public static function submit() {
        global $CRAYON_EMAIL;
        CrayonSettingsWP::load_settings();
        $id = $_POST['id'];
        $message = $_POST['message'];
        $dir = CrayonResources::themes()->dirpath($id);
        $dest = $dir . 'tmp';
        @mkdir($dest);

        if (is_dir($dir) && CrayonResources::themes()->exists($id)) {
            try {
                $zipFile = CrayonUtil::createZip($dir, $dest, TRUE);
                $result = CrayonUtil::emailFile(array(
                    'to' => $CRAYON_EMAIL,
                    'from' => get_bloginfo('admin_email'),
                    'subject' => 'Theme Editor Submission',
                    'message' => $message,
                    'file' => $zipFile
                ));
                CrayonUtil::deleteDir($dest);
                if ($result) {
                    echo 1;
                } else {
                    echo -3;
                }
            } catch (Exception $e) {
                CrayonLog::syslog($e->getMessage(), "THEME SUBMIT");
                echo -2;
            }
        } else {
            echo -1;
        }
        exit();
    }

    public static function getCSSInfo($css) {
        $info = array();
        preg_match(self::RE_COMMENT, $css, $matches);
        if (count($matches)) {
            $comment = $matches[0];
            preg_match_all('#([^\r\n:]*[^\r\n\s:])\s*:\s*([^\r\n]+)#msi', $comment, $matches);
            if (count($matches)) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $name = $matches[1][$i];
                    $value = $matches[2][$i];
                    $info[self::getFieldID($name)] = $value;
                }
            }
        }
        return $info;
    }

    public static function cssInfoToString($info) {
        $str = "/*\n";
        foreach ($info as $id => $value) {
            $str .= self::getFieldName($id) . ': ' . $value . "\n";
        }
        $str .= "*/";
        return $str;
    }

    public static function setCSSInfo($css, $info) {
        return preg_replace(self::RE_COMMENT, self::cssInfoToString($info), $css);
    }

    public static function getFieldID($name) {
        if (isset(self::$infoFieldsInverse[$name])) {
            return self::$infoFieldsInverse[$name];
        } else {
            return CrayonUserResource::clean_id($name);
        }
    }

    public static function getFieldName($id) {
        if (isset(self::$infoFields[$id])) {
            return self::$infoFields[$id];
        } else {
            return CrayonUserResource::clean_name($id);
        }
    }

    public static function getAttributeGroup($attribute) {
        if (isset(self::$attributeGroupsInverse[$attribute])) {
            return self::$attributeGroupsInverse[$attribute];
        } else {
            return $attribute;
        }
    }

    public static function getAttributeType($group) {
        if (isset(self::$attributeTypesInverse[$group])) {
            return self::$attributeTypesInverse[$group];
        } else {
            return 'text';
        }
    }

}

if (defined('ABSPATH') && is_admin()) {
    add_action('init', 'CrayonThemeEditorWP::init');
}

?>