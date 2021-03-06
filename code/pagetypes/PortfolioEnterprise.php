<?php

/**
 * Class PortfolioEnterprise
 */
class PortfolioEnterprise extends PortfolioPage
{
    private static $singular_name = "[Portfolio] Enterprise project";

    private static $plural_name = "[Portfolio] Enterprise projects";

    private static $description = "Projects completed for current employer";

    private static $can_be_root = false;

    private static $allowed_children = array();

    private static $db = array(
        'DisplayOnHomepage'  => 'Boolean(1)',
        'ProjectLeftColumn'  => 'HTMLText',
        'ProjectRightColumn' => 'HTMLText',
        'ProjectButtonInfo'  => 'HTMLText',
    );

    private static $has_one = array(
        "ProjectImage" => "Image",
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.HomepageDetails', array(
            DropdownField::create('DisplayOnHomepage', 'Display this on the homepage')
                ->setSource(array(true => "Yes", false => "No"))
                ->setDescription("<strong>Note:</strong> Only one project can be set as the homepage project at a time"),

            UploadField::create('ProjectImage', "Cover image")->setFolderName('Uploads/Screenshots/'),
            HtmlEditorField::create("ProjectLeftColumn", "Left column")->setRows(2),
            HtmlEditorField::create("ProjectRightColumn", "Right column")->setRows(2),
            HtmlEditorField::create("ProjectButtonInfo", "Bottom column")->setRows(2),
        ));

        return $fields;
    }

    /**
     * An over complicated way to make sure only one project is set to display on the homepage at a time.
     */
    public function onBeforeWrite()
    {

        parent::onBeforeWrite();

        if ($this->DisplayOnHomepage == false) {
            return;
        }

        if (!DataObject::get($this->ClassName)) {
            return;
        }

        foreach (DataObject::get($this->ClassName) as $item) {
            if ($item->ID != $this->ID) {
                $item->DisplayOnHomepage = false;
                $item->write();
            }
        }
    }

}

/**
 * Class PortfolioEnterprise_Controller
 */
class PortfolioEnterprise_Controller extends PortfolioPage_Controller
{

}