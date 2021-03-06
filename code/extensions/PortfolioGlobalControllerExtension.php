<?php

/**
 * Class PortfolioGlobalControllerExtension
 */
class PortfolioGlobalControllerExtension extends DataExtension
{

    /**
     * Get enterprise based projects
     *
     * @return mixed
     */
    public function getEnterprise()
    {
        return PortfolioEnterprise::get()->sort(array("Created" => "DESC"));
    }

    /**
     * Get community based projects
     *
     * @return mixed
     */
    public function getCommunity()
    {
        return PortfolioCommunity::get()->sort(array("Title" => "ASC"));
    }

    /**
     * Get community items for the homepage
     *
     * @return mixed
     */
    public function getHomepageCommunity()
    {
        return PortfolioCommunity::get()
            ->filter(array("DisplayOnHomepage" => true))
            ->sort(array("Title" => "ASC"))
            ->limit(3);
    }

    /**
     * @return mixed
     */
    public function getHomepageEnterprise()
    {
        return PortfolioEnterprise::get()->filter(array("DisplayOnHomepage" => true));
    }

    /**
     * Get contact links for the footer
     *
     * @return mixed
     */
    public function getFooterLink()
    {
        return PortfolioFooterLinks::get();
    }

    /**
     * Sets the success or failure message for the form submission. Could probably simplify this a bit
     *
     * @return ArrayData|bool
     */
    function statusMessage()
    {
        if (Session::get('ActionMessage')) {
            $message = Session::get('ActionMessage');
            $status = Session::get('ActionStatus');

            Session::clear('ActionStatus');
            Session::clear('ActionMessage');

            return new ArrayData(array(
                'Message' => $message,
                'Status'  => $status
            ));
        }

        return false;
    }

}
